# imagecollections.ca

Static copy of the Image Collections website (formerly Joomla 2.5), hosted on Cloudflare Pages.

- `public/` is the site that gets served. Edit the HTML here to change content.
- `tools/` holds the scripts used to convert the old Joomla site (kept for reference).

## Cloudflare Pages settings

- Build command: `npx pagefind --site public`
- Build output directory: `public`

The build command creates the search index (`public/pagefind/`, not stored in git).

`public/_redirects` holds the redirects, and `public/404.html` is the not-found page.
