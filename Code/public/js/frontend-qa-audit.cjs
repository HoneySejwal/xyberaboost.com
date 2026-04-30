#!/usr/bin/env node
const fs = require('fs');
const path = require('path');

const root = process.cwd();
const viewsRoot = path.join(root, 'resources', 'views');

function listFiles(dir, exts = ['.php', '.blade.php']) {
  const out = [];
  for (const entry of fs.readdirSync(dir, { withFileTypes: true })) {
    const full = path.join(dir, entry.name);
    if (entry.isDirectory()) out.push(...listFiles(full, exts));
    else if (exts.some((e) => entry.name.endsWith(e))) out.push(full);
  }
  return out;
}

function read(file) { try { return fs.readFileSync(file, 'utf8'); } catch { return ''; } }
function rel(file) { return path.relative(root, file); }

const checks = [];
function add(status, name, details) { checks.push({ status, name, details }); }

const bladeFiles = listFiles(viewsRoot);
const allText = bladeFiles.map((f) => ({ file: f, text: read(f) }));

const forbiddenTerms = [
  { pattern: /\bCredits\b/i, level: 'FAIL' },
  { pattern: /\bWallet\b/i, level: 'FAIL' },
  { pattern: /\bRedeem\b/i, level: 'WARN' }
];
for (const term of forbiddenTerms) {
  const hits = allText.filter(({ text, file }) => term.pattern.test(text) && !file.includes(' - Copy.php') && !file.includes('12-12-2025 header.blade.php'));
  add(hits.length ? term.level : 'PASS', `Forbidden term ${term.pattern}`, hits.slice(0, 20).map((h) => rel(h.file)).join(', ') || 'none');
}

const homeFile = path.join(root, 'resources/views/frontend/index.blade.php');
const homeText = read(homeFile);
add(homeText.includes('Purchased points can only be used on this website.') ? 'PASS' : 'FAIL', 'Homepage disclaimer present', rel(homeFile));

const newsletterHits = allText.filter(({ text }) => text.includes('Subscribe to our newsletter'));
add(newsletterHits.length ? 'PASS' : 'WARN', 'Newsletter exact wording usage', newsletterHits.slice(0, 20).map((h) => rel(h.file)).join(', ') || 'not found');

const placeholderPatterns = [/lorem ipsum/i, /dummy/i, /TBD/i, /Coming soon/i, /no order yet!!/i];
const placeholderHits = [];
for (const { file, text } of allText) {
  for (const p of placeholderPatterns) if (p.test(text)) { placeholderHits.push(rel(file)); break; }
}
add(placeholderHits.length ? 'WARN' : 'PASS', 'Placeholder text scan', placeholderHits.slice(0, 30).join(', ') || 'none');

const headFile = path.join(root, 'resources/views/frontend/layouts/head.blade.php');
const headText = read(headFile);
add(/<title>/i.test(headText) ? 'PASS' : 'FAIL', 'Title tag exists', rel(headFile));
add(/meta\s+name=["']description["']/i.test(headText) ? 'PASS' : 'WARN', 'Meta description tag exists', rel(headFile));
add(/property=["']og:title["']/i.test(headText) && /property=["']og:description["']/i.test(headText) ? 'PASS' : 'WARN', 'OG title/description tags exist', rel(headFile));

const badRoutes = ['/test-email', '/cache-clear', '/storage-link'];
for (const route of badRoutes) {
  const hits = allText.filter(({ text }) => text.includes(route));
  add(hits.length ? 'WARN' : 'PASS', `Exposed route reference ${route}`, hits.map((h) => rel(h.file)).join(', ') || 'none');
}

const pointsDecimalHits = allText.filter(({ text }) => /points[^\n]*\d+\.\d+/i.test(text));
add(pointsDecimalHits.length ? 'WARN' : 'PASS', 'Points decimal display heuristic', pointsDecimalHits.map((h) => rel(h.file)).join(', ') || 'none');

let pass = 0, warn = 0, fail = 0;
for (const c of checks) {
  if (c.status === 'PASS') pass++; else if (c.status === 'WARN') warn++; else fail++;
  console.log(`[${c.status}] ${c.name}: ${c.details}`);
}
console.log(`\nSummary: PASS=${pass} WARN=${warn} FAIL=${fail}`);
process.exit(fail ? 1 : 0);
