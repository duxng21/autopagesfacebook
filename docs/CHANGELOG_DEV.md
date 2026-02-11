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
