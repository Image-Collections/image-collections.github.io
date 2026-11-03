#!/usr/bin/env python3
"""Turn the raw wget mirror of imagecollections.ca into a clean static site.

usage: python3 -I build.py <mirror_dir> <out_dir>
"""
import os, re, shutil, sys

src, dst = sys.argv[1:3]
if os.path.exists(dst):
    sys.exit(f"refusing to overwrite existing {dst}")

SELF = r"https?://(?:www\.)?imagecollections\.ca"
HTTPS_HOSTS = r"(?:t\d\.gstatic\.com|encrypted-tbn\d\.gstatic\.com|www\.youtube\.com|www\.facebook\.com|en\.wikipedia\.org|www\.previewsworld\.com)"

REDIRECT_JS = (
    "<script>(function(){var m=location.search.match(/[?&](?:limit)?start=(\\d+)/);"
    "if(m&&!/\\/start-\\d+$/.test(location.pathname)){var p=location.pathname.replace(/\\/$/,'');"
    "location.replace(p+(m[1]==='0'?'':'/start-'+m[1]));}})();</script>"
)
SEARCH_HEAD = '<link href="/pagefind/pagefind-ui.css" rel="stylesheet" />\n'
SEARCH_TAIL = (
    '<script src="/pagefind/pagefind-ui.js"></script>\n'
    '<script>window.addEventListener("DOMContentLoaded",function(){'
    'if(window.PagefindUI&&document.getElementById("search")){'
    'new PagefindUI({element:"#search",showImages:false,resetStyles:false});}});</script>\n'
)

stats = {"pages": 0, "assets": 0, "skipped": [], "renamed": 0}


def map_name(rel):
    """Return the output path for a mirror file, or None to skip it."""
    name = os.path.basename(rel)
    if "?" not in name:
        return rel
    if "task=article.edit" in name or "format=feed" in name or "format=opensearch" in name:
        return None
    m = re.match(r"^(.*)\?(?:limit)?start=(\d+)\.html$", name)
    if m:
        base, n = m.group(1), int(m.group(2))
        if n == 0:
            return None  # same page as the base page
        stats["renamed"] += 1
        return os.path.join(os.path.dirname(rel), base, f"start-{n}.html")
    return None


def fix_html(t):
    t = re.sub(r"<base\s+href=\"[^\"]*\"\s*/?>\s*", "", t)
    # only inside attribute values (preceded by a quote), never in visible text
    t = re.sub(r"([\"'])" + SELF + r"/", r"\1/", t)
    t = re.sub(r"([\"'])" + SELF + r"(?=[\"'])", r"\1/", t)
    # drop feed / opensearch discovery links
    t = re.sub(r"<link[^>]*(?:opensearch|application/(?:rss|atom)\+xml)[^>]*>\s*", "", t)
    # drop (empty) admin edit buttons
    t = re.sub(r"<div class=\"edit\">.*?</div>\s*", "", t, flags=re.S)
    t = re.sub(r"<a [^>]*task=article\.edit[^>]*>\s*(?:<img[^>]*>\s*)?</a>", "", t)
    # pagination links: /x/y?start=N -> /x/y/start-N ; limitstart=0 -> /x/y
    def pag(m):
        path, n = m.group(1), int(m.group(2))
        return f'href="{path}"' if n == 0 else f'href="{path}/start-{n}"'
    t = re.sub(r"href=\"(/[^\"?#]*)\?(?:limit)?start=(\d+)\"", pag, t)
    # external hosts that support https
    t = re.sub(r"([\"'])http://(" + HTTPS_HOSTS + ")", r"\1https://\2", t)
    # replace Joomla search form with Pagefind mount point
    t = re.sub(r"<form[^>]*>\s*<div class=\"search\">.*?</form>", '<div id="search"></div>', t, flags=re.S)
    t = t.replace('<div id="comp-i">', '<div id="comp-i" data-pagefind-body>', 1)
    t = t.replace("</head>", SEARCH_HEAD + REDIRECT_JS + "\n</head>", 1)
    t = t.replace("</body>", SEARCH_TAIL + "</body>", 1)
    return t


for root, dirs, files in os.walk(src):
    rel_root = os.path.relpath(root, src)
    if rel_root == "." or rel_root.split(os.sep)[0] != "component":
        pass
    if rel_root.split(os.sep)[0] in ("component",):
        dirs[:] = []
        continue
    for f in files:
        rel = os.path.normpath(os.path.join(rel_root, f))
        out_rel = map_name(rel)
        if out_rel is None:
            stats["skipped"].append(rel)
            continue
        out = os.path.join(dst, out_rel)
        os.makedirs(os.path.dirname(out), exist_ok=True)
        if f.endswith(".html"):
            with open(os.path.join(root, f), encoding="utf-8", errors="surrogateescape") as fh:
                t = fh.read()
            with open(out, "w", encoding="utf-8", errors="surrogateescape") as fh:
                fh.write(fix_html(t))
            stats["pages"] += 1
        else:
            shutil.copy2(os.path.join(root, f), out)
            stats["assets"] += 1

# extra files
with open(os.path.join(dst, "_redirects"), "w") as fh:
    fh.write("/index.php  /  301\n/index.php/*  /:splat  301\n")
with open(os.path.join(dst, "robots.txt"), "w") as fh:
    fh.write("User-agent: *\nAllow: /\n")
with open(os.path.join(dst, "404.html"), "w") as fh:
    fh.write(
        '<!DOCTYPE html><html lang="en"><head><meta charset="utf-8"/>'
        '<meta name="viewport" content="width=device-width, initial-scale=1"/>'
        "<title>Page not found - Image Collections</title>"
        '<link rel="stylesheet" href="/templates/ebusiness/css/styles.css"/></head>'
        '<body class="background"><div id="main"><div id="wrapper"><div id="main-content">'
        "<h2>Sorry, that page isn't here.</h2>"
        '<p>Try the <a href="/">Image Collections home page</a> or the <a href="/contact-us">contact page</a>.</p>'
        "</div></div></div></body></html>\n"
    )

print(f"pages={stats['pages']} assets={stats['assets']} renamed_pagination={stats['renamed']} skipped={len(stats['skipped'])}")
