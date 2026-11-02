#!/usr/bin/env python3
"""Check internal links/assets of the built site resolve like Cloudflare Pages.

usage: python3 -I check.py <site_dir>
"""
import os, re, sys, urllib.parse, collections

site = sys.argv[1]


def resolves(path):
    p = urllib.parse.unquote(path.split("#")[0].split("?")[0]).lstrip("/")
    if p == "":
        return os.path.isfile(os.path.join(site, "index.html"))
    cands = [p, p + ".html", os.path.join(p, "index.html")]
    if p.endswith("/"):
        cands = [os.path.join(p, "index.html")]
    return any(os.path.isfile(os.path.join(site, c)) for c in cands)


missing = collections.defaultdict(set)
leftovers = collections.Counter()
npages = 0
for root, _, files in os.walk(site):
    for f in files:
        if not f.endswith(".html"):
            continue
        npages += 1
        rel = os.path.relpath(os.path.join(root, f), site)
        t = open(os.path.join(root, f), encoding="utf-8", errors="replace").read()
        for pat, label in [(r"imagecollections\.ca/", "absolute self link"), (r"\?(?:limit)?start=", "?start link"),
                           (r"article\.edit", "edit link"), (r"<base ", "base tag"), (r"searchword", "old search form")]:
            if re.search(pat, t):
                leftovers[label] += 1
        for m in re.finditer(r"""(?:href|src)=["'](/[^"'#]*)""", t):
            u = m.group(1).replace("&amp;", "&")
            if u.startswith("//"):
                continue
            if not resolves(u):
                missing[u].add(rel)

print(f"pages checked: {npages}")
print("leftovers:", dict(leftovers) or "none")
print(f"unresolved internal targets: {len(missing)}")
for u, pages in sorted(missing.items(), key=lambda kv: -len(kv[1]))[:60]:
    print(f"  {len(pages):4d} page(s)  {u}")
