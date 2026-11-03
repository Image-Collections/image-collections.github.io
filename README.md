# imagecollections.ca

Static copy of the Image Collections website (formerly Joomla 2.5), hosted on Cloudflare Pages.

- `public/` is the site that gets served. Edit the HTML here to change content.
- `tools/` holds the scripts used to convert the old Joomla site (kept for reference).

## Hosting (GitHub Pages)

Every push to `main` runs `.github/workflows/pages.yml`, which builds the search index
(`npx pagefind --site public`, output not stored in git) and publishes `public/`.

In the repo settings, Pages → Source must be set to **GitHub Actions**.

`public/404.html` is the not-found page. `public/_redirects` is only used if the site is
moved to Cloudflare Pages (GitHub Pages ignores it).
