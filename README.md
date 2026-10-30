# narashinocatholic

WordPress website for カトリック習志野教会 (Catholic Narashino Church), built from the homepage design in the [Narashino Church Website Redesign](https://claude.ai/artifact/SUUYLBtNxk56AB2ssFoCUU) artifact.

## Layout

- `wp-content/themes/narashino-catholic/`: the theme. Copy it into `wp-content/themes/` on any WordPress 6.4+ site (PHP 7.4+).
- `docker-compose.yml`: local WordPress and MariaDB with the theme mounted.

## Run locally

```bash
docker compose up -d
```

Open http://localhost:8080, finish the WordPress install, then activate **Narashino Catholic** under Appearance > Themes.

## First-time setup

1. Settings > General: set the site language to 日本語 and the timezone to Tokyo.
2. Settings > Permalinks: choose "Post name".
3. Pages: create an empty page named お知らせ, then set it as the posts page under Settings > Reading. The "すべてのお知らせ" link points there.
4. Appearance > Customize: fill in the address, phone, email, directions, Mass times, and the priest's name, photo, and message. Any field left at its default shows as a dashed placeholder, so unfilled details are easy to spot. Clearing the announcement text hides the bar.
5. Posts: write notices. The newest three appear on the homepage.
   - Optional: fill in the English title and summary in the "English text" box under the post editor.
   - Optional: put a post in a category named 注意 with slug `caution` to give it the warning style.

## Where things live

- `front-page.php`: homepage sections, in design order. Section copy is written in the template.
- `header.php` and `footer.php`: announcement bar, navigation, and contact block shared by every page.
- `inc/customizer.php`: the Customizer settings and their placeholder defaults.
- `inc/post-meta.php`: the English text box on posts.
- `style.css`: all styles, taken from the design.
