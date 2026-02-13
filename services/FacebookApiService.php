<?php

class FacebookApiService
{
    private $version;

    public function __construct(?string $version = null)
    {
        $this->version = $version ?: (defined('FB_GRAPH_VERSION') ? FB_GRAPH_VERSION : 'v19.0');
    }

    public function getUserPages(string $userToken): array
    {
        return $this->requestGet(
            $this->graphUrl('/me/accounts'),
            [
                'fields' => 'id,name,access_token',
                'access_token' => $userToken,
            ]
        );
    }

    public function getPageInfo(string $pageId, string $userToken): array
    {
        return $this->requestGet(
            $this->graphUrl("/{$pageId}"),
            [
                'fields' => 'name,access_token,picture.type(square)',
                'access_token' => $userToken,
            ]
        );
    }

    public function postText(string $pageId, string $pageToken, string $message, ?int $scheduleTs = null): array
    {
        $params = [
            'message' => $message,
            'access_token' => $pageToken,
        ];

        if ($scheduleTs) {
            $params['published'] = 'false';
            $params['scheduled_publish_time'] = $scheduleTs;
        }

        return $this->requestPost($this->graphUrl("/{$pageId}/feed"), $params);
    }

    public function uploadPhotoUnpublished(string $pageId, string $pageToken, string $absPath): array
    {
        return $this->requestPost(
            $this->graphUrl("/{$pageId}/photos"),
            [
                'access_token' => $pageToken,
                'published' => 'false',
                'source' => new CURLFile($absPath),
            ],
            true
        );
    }

    public function postImages(string $pageId, string $pageToken, string $message, array $photoIds, ?int $scheduleTs = null): array
    {
        $attached = [];
        foreach ($photoIds as $id) {
            $attached[] = ['media_fbid' => $id];
        }

        $params = [
            'message' => $message,
            'attached_media' => json_encode($attached),
            'access_token' => $pageToken,
        ];

        if ($scheduleTs) {
            $params['published'] = 'false';
            $params['scheduled_publish_time'] = $scheduleTs;
        }

        return $this->requestPost($this->graphUrl("/{$pageId}/feed"), $params);
    }

    public function postVideo(string $pageId, string $pageToken, string $absPath, string $message = '', ?int $scheduleTs = null): array
    {
        $params = [
            'access_token' => $pageToken,
            'description' => $message,
            'source' => new CURLFile($absPath),
        ];

        if ($scheduleTs) {
            $params['published'] = 'false';
            $params['scheduled_publish_time'] = $scheduleTs;
        }

        return $this->requestPost($this->graphUrl("/{$pageId}/videos"), $params, true);
    }

    public function deletePost(string $postId, string $pageToken): array
    {
        return $this->requestDelete(
            $this->graphUrl("/{$postId}"),
            ['access_token' => $pageToken]
        );
    }

    private function graphUrl(string $path): string
    {
        return 'https://graph.facebook.com/' . $this->version . $path;
    }

    private function requestGet(string $url, array $query): array
    {
        $fullUrl = $url . '?' . http_build_query($query);

        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $fullUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CONNECTTIMEOUT => 10,
            CURLOPT_TIMEOUT => 20,
        ]);

        $raw = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);

        if ($err) {
            return ['error' => ['message' => $err]];
        }

        return $this->decodeResponse($raw);
    }

    private function requestPost(string $url, array $params, bool $isMultipart = false): array
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);

        if ($isMultipart) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        } else {
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
        }

        $raw = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);

        if ($err) {
            return ['error' => ['message' => $err]];
        }

        return $this->decodeResponse($raw);
    }

    private function requestDelete(string $url, array $params): array
    {
        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'DELETE',
            CURLOPT_POSTFIELDS => http_build_query($params),
            CURLOPT_CONNECTTIMEOUT => 10,
            CURLOPT_TIMEOUT => 20,
        ]);

        $raw = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);

        if ($err) {
            return ['error' => ['message' => $err]];
        }

        return $this->decodeResponse($raw);
    }

    private function decodeResponse($raw): array
    {
        $data = json_decode((string)$raw, true);
        return is_array($data) ? $data : ['error' => ['message' => 'Invalid JSON']];
    }
}