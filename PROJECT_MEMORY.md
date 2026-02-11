# Project Memory

## 0) Quy tac lam viec voi AI (BAT BUOC)
- AI duoc phep doc file de kiem tra/phan tich khi user yeu cau.
- AI KHONG duoc sua, tao, xoa, ghi de bat ky file nao neu chua duoc user cho phep edit ro rang.
- Mac dinh: AI chi gui code/diff de user tu dan.
- Khi sang phien moi, phai doc file nay va `docs/CHANGELOG_DEV.md` truoc khi lam viec.

## 1) Tong quan
- Ten du an: `code3`
- Muc tieu: Quan ly va dang bai Facebook Pages (text, image, video), ho tro dang lai, xoa bai, cron cap nhat token/trang thai.
- Stack: PHP MVC (khong framework), MySQL, Vuexy UI.

## 2) Kien truc hien tai
- Front controller: `index.php`
- Common:
- `commons/env.php` (DB, BASE_URL, FB_GRAPH_VERSION, PATH_ROOT)
- `commons/function.php` (DB connect, upload/delete file, flash status, Facebook API helpers)
- Controllers:
- `controllers/LoginController.php`
- `controllers/PagesController.php`
- `controllers/PostsController.php`
- `controllers/ProductController.php`
- Models:
- `models/BaseModel.php`
- `models/AdminModel.php`
- `models/FbPageModel.php`
- `models/PostModel.php`
- `models/ProductModel.php` (placeholder)
- Views:
- `views/pages/login.php`
- `views/pages/pages.php` (cau hinh pages)
- `views/pages/posts/index.php` (list + modal repost)
- `views/pages/posts/create.php` (post-add)
- Cron:
- `cron.php` (cap nhat token pages + cap nhat scheduled -> posted)

## 3) Route map (`index.php`)
- `?act=/` -> `ProductController::Home()`
- `?act=login` -> `LoginController::login()`
- `?act=logout` -> `LoginController::logout()`
- `?act=pages` -> GET `PagesController::index()`, POST `PagesController::store()`
- `?act=pages-delete` -> `PagesController::delete()` (POST + CSRF)
- `?act=posts` -> `PostsController::index()`
- `?act=post-add` -> `PostsController::create()` (GET form + POST submit)
- `?act=post-delete` -> `PostsController::delete()` (POST + CSRF)
- `?act=post-repost` -> `PostsController::repost()` (POST + CSRF + multi page)
- `?act=menus` -> `MenusController::index()`
- `?act=menu-add` -> `MenusController::create()` (POST)
- `?act=menu-edit` -> `MenusController::edit()` (GET/POST)
- `?act=menu-delete` -> `MenusController::delete()` (POST + CSRF)

## 4) DB schema quan trong
- `admins`: login admin (`username`, `password` hash)
- `fb_pages`:
- `page_id` (unique)
- `page_name`
- `page_avatar`
- `access_token` (user token)
- `token_page` (page token)
- `posts`:
- `menu_id` (FK -> `menus.id`, nullable)
- `page_id`
- `fb_post_id`
- `content`
- `media_type` enum: `image|video|none`
- `media_path` (string hoac JSON list path image)
- `status` enum: `draft|scheduled|posted`
- `scheduled_at`, `posted_at`
- `menus`:
- `id`
- `name` (unique)
- `created_at`, `updated_at`

## 5) Luong chuc nang da hoan thanh

### Auth
- Session cookie hardening trong `index.php` (`httponly`, `samesite=lax`, `secure` theo HTTPS).
- Login su dung `password_verify`.
- Rate-limit theo session: khoa tam 5 phut neu sai >= 5 lan.
- CSRF check cho login form.
- Redirect thong bao qua query `msg=login_ok|logout`.

### Pages
- Form nhap user access token trong `views/pages/pages.php`.
- Goi Graph `/me/accounts` de lay pages.
- Upsert theo `page_id` (trung id thi cap nhat lai `page_name`, `page_avatar`, `access_token`, `token_page`).
- Xoa page bang POST + CSRF.

### Posts
- Tao bai tu `post-add`:
- Co chon danh muc (`menu_id`) khi tao bai.
- Text only -> `/{page_id}/feed`
- Text + images -> upload tung anh unpublished `/{page_id}/photos`, sau do feed voi `attached_media`
- Text + 1 video -> `/{page_id}/videos`
- Luu ket qua vao bang `posts` theo tung page duoc chon.
- Ho tro schedule (status `scheduled`, timestamp chuyen tu `Asia/Ho_Chi_Minh`).
- List posts + phan trang server-side (`perPage = 8` trong `PostsController::index`).
- Xoa bai:
- Xoa tren Facebook bang `fbDeletePost`
- Xoa file local (1 file hoac JSON list)
- Xoa row DB.
- Dang lai bai:
- Mo modal trong list, chon nhieu page bang Select2.
- Dung lai du lieu post cu (text/media), dang len pages da chon.
- Insert row moi vao `posts` nhu bai moi (giu `menu_id` cua bai goc).
- List posts:
- Ho tro loc theo nhieu danh muc (`menu_ids[]`) bang Select2.
- Auto submit filter khi chon/bo chon.
- Pagination giu query filter.

### Menus
- CRUD danh muc co ban:
- List + Add tren cung trang `views/pages/menus/index.php`.
- Edit tren `views/pages/menus/edit.php`.
- Delete bang POST + CSRF.

### Cron (`cron.php`)
- Cap nhat token pages:
- Loop `fb_pages`, dung `access_token` (user token) goi `/{page_id}?fields=name,access_token,picture`
- Update lai `page_name`, `page_avatar`, `token_page`.
- Cap nhat trang thai post:
- Goi `PostModel::markScheduledToPosted()`
- SQL: `scheduled -> posted` khi `scheduled_at <= now(+07:00)`, set `posted_at`.

## 6) Quy uoc ky thuat
- CSRF key: `$_SESSION['csrf']` dung chung cho login/pages/posts.
- Flash message:
- `set_status(type, message)`
- `show_status()` xoa message sau khi render.
- Upload path:
- luu tuong doi trong DB, vi du `uploads/posts/...`
- xoa file local qua `deleteFile`.
- Danh muc:
- `posts.menu_id` de loc list va giu context khi repost.
- Timezone:
- schedule convert bang `DateTimeZone('Asia/Ho_Chi_Minh')`.
- cron update status dung `CONVERT_TZ(..., '+00:00', '+07:00')`.

## 7) Moi truong chay
- `BASE_URL`: `http://localhost/code3`
- DB: host `localhost`, port `3306`, db `code_2`, user `root`
- `FB_GRAPH_VERSION`: `v19.0`
- PHP ext can co: `curl`, `pdo_mysql`, `mbstring`

## 8) Cach test nhanh
1. Login: `?act=login`
2. Pages:
- vao `?act=pages`
- nhap user token -> luu pages/token.
3. Post add:
- vao `?act=post-add`
- chon pages + danh muc + content + media/schedule -> submit.
4. Post list:
- vao `?act=posts` de xem status/media/repost/delete/pagination.
- loc theo danh muc bang Select2.
5. Repost:
- bam `Dang lai` tren card -> chon pages trong modal -> submit.
6. Delete:
- bam `Xoa bai` -> xoa FB + local file + DB.
7. Cron:
- goi `http://localhost/code3/cron.php`
- kiem tra JSON `results` + status post scheduled da doi sang posted.
8. Menus:
- `?act=menus` de them/list.
- `?act=menu-edit&id=<id>` de sua.

## 9) Known issues / can luu y
- Phan text tieng Viet trong mot so file dang bi loi encoding hien thi trong terminal.
- `uploadFile` hien tai giu nguyen ten file goc, co the can sanitize ten file neu gap ky tu dac biet.
- `cron.php` chua co secret key bao ve endpoint.

## 10) TODO uu tien
1. Them cron secret (`?key=...`) hoac chi cho phep CLI.
2. Tach service/layer cho Facebook API de de test va retry.
3. Bo sung log chi tiet (thanh cong/that bai) cho post/repost/delete.
4. Chuan hoa UTF-8 cho toan bo file view.
5. Them xac nhan xoa 2 buoc cho danh muc/theo yeu cau nghiep vu.
