# Dev Changelog

## 2026-02-11
### Added
- Auth flow: login/logout voi CSRF, rate-limit, session hardening.
- Pages module:
- Nhap user token, fetch `/me/accounts`, upsert `fb_pages`.
- Xoa page bang POST + CSRF.
- Posts module:
- Create post text/image/video + schedule.
- Save post metadata vao DB (`posts`).
- Delete post tren Facebook + local media + DB row.
- Repost qua modal (chon nhieu pages bang Select2), insert row moi.
- Server-side pagination cho list posts.
- Cron:
- Cap nhat token page (`fb_pages`).
- Cap nhat status `scheduled -> posted`.

### Changed
- Route map trong `index.php`:
- Them `pages`, `pages-delete`, `posts`, `post-add`, `post-delete`, `post-repost`.
- `default` duoc de cuoi `match`.
- UI posts list:
- Card render theo `media_type`.
- Modal repost dat trong vong `foreach`.
- Gioi han text hien thi tren card.

### Fixed
- CSRF/route flow cho delete/repost.
- Timezone schedule: convert `datetime-local` theo `Asia/Ho_Chi_Minh`.
- Xoa media local an toan ca truong hop 1 file va JSON list.
- Cron update posts khong truy cap thuoc tinh protected (`conn`) truc tiep.

### Notes
- Files touched (major):
- `index.php`
- `commons/env.php`
- `commons/function.php`
- `controllers/LoginController.php`
- `controllers/PagesController.php`
- `controllers/PostsController.php`
- `models/BaseModel.php`
- `models/AdminModel.php`
- `models/FbPageModel.php`
- `models/PostModel.php`
- `views/pages/login.php`
- `views/pages/pages.php`
- `views/pages/posts/create.php`
- `views/pages/posts/index.php`
- `cron.php`

## 2026-02-11 (Session Update)
### Added
- Menu module hoan thien cho flow hien tai:
- CRUD co ban (`menus`, `menu-add`, `menu-edit`, `menu-delete`).
- Posts ho tro `menu_id`:
- Chon danh muc khi tao bai (`post-add`).
- Repost giu `menu_id` cua bai goc.
- Loc list posts theo nhieu danh muc (Select2, auto submit, pagination giu filter).

### Changed
- Tai lieu memory duoc cap nhat de bo sung route/menu schema/flow moi.
- Quy tac lam viec voi AI duoc ghi ro trong `PROJECT_MEMORY.md`:
- Khong tu y sua file neu chua duoc user cho phep edit ro rang.
- Mac dinh chi gui code/diff de user tu dan.

### Notes
- Khi bat dau phien moi: doc `PROJECT_MEMORY.md` va `docs/CHANGELOG_DEV.md` truoc.

## 2026-02-14 (Session Update)
### Added
- Tach Facebook API thanh service rieng: `services/FacebookApiService.php`.
- Bo sung route va flow sua bai:
- `post-edit` (GET/POST), prefill theo id.
- Cap nhat noi dung bai len Facebook + cap nhat `menu_id` local.
- Publish ngay bai dang `scheduled` khi tat lich (neu API cho phep).
- Bo sung submit AJAX cho `post-add` (hien alert dang xu ly, tra JSON ket qua).
- Bo sung module dang bai hang loat:
- Route `posts-batch`.
- Form chon nhieu pages + dai id bai nguon + ngay bat dau + khung gio.
- Bang queue moi `post_queue` de luu ke hoach dang hang loat.
- Bo sung `batch_id` de theo doi theo tung dot len lich.
- UI batch co danh sach batch + chi tiet theo `view_batch_id`.

### Changed
- `PostsController` goi truc tiep `FacebookApiService`, khong dung helper Facebook trong `commons/function.php`.
- `cron.php` gop 3 luong:
- Refresh page token.
- Worker xu ly `post_queue` (queued -> processing -> posted/failed).
- Dong bo bai thanh cong sang bang `posts`.
- Xu ly scheduled cu (`posts`).
- Gioi han xu ly queue moi lan cron: 8 jobs/run.
- Home dashboard (`?act=/`) bo sung thong ke cho queue batch:
- Tong job, queued/processing, posted, failed.
- Khong loc thi tong toan bo, loc `page_id` thi theo page.

### Fixed
- Chuan hoa so sanh gio den han queue theo gio local (tranh dang som job chua den gio).
- Khoa switch len lich tren man edit khi bai da `posted` de tranh hieu nham UX.

### Notes
- Tai lieu memory da dat tai `docs/PROJECT_MEMORY.md`.
- Khuyen nghi `post_queue.media_path` dung `TEXT` neu co kha nang luu JSON nhieu anh.

## 2026-02-22 (Session Update)
### Added
- Chuc nang "Luu nhap (Khong dang len FB)" trong trang them bai viet (`post-add`).
- Giao dien `views/pages/posts/create.php` bo sung switch `is_draft`. Su dung JS de xu ly toggle doc quyen giua switch "Luu nhap" va "Len lich".
- Logic server `PostsController.php`: khi `is_draft` duoc bat roi, he thong se huy bo trang thai len lich (`isScheduled = false`), luu file media local nhu binh thuong, nhung hoan toan bo qua cac API call sang Facebook (Graph API). Database luu trang thai mang gia tri `draft` theo schema hien co, va `fb_post_id` la `null`.

### Changed
- Refactor nhe dau ham `create()` trong `PostsController`.
- Sua ham `delete()` trong `PostsController` de bo qua Facebook API neu bai co trang thai `draft` (hoac khong co `fb_post_id`), giup the xoa file anh/video va xoa row DB an toan cho cac ban nhap.
