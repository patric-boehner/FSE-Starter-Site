---

## Overview

This theme is built using a **hybrid design system** that balances flexibility for content editors with long-term maintainability and visual consistency. It embraces the strengths of the WordPress Block Editor while putting guardrails in place to prevent design drift and reduce technical debt.

---

## Guiding Principles

1. **Design System First**
   All layout, spacing, colors, and typography are defined through a consistent design system using `theme.json`. Editors choose from defined presets rather than creating custom values.

2. **Component-Based Structure**
   CSS and patterns are organized around reusable components and sections rather than page-specific layouts. This supports modular design and makes future extension more manageable.

3. **Block Editor Alignment**
   Editor styles are carefully matched to front-end styles to ensure WYSIWYG editing. Shared styles are included in both environments. Front-end-only styles are scoped and structured separately.

4. **Guardrails Over Total Freedom**
   The theme intentionally limits design freedom in the Block Editor to maintain visual coherence. Block styles, variations, and patterns are provided to guide content creation without overwhelming editors with too many options.

5. **Developer Collaboration, Not Lock-In**
   When new design patterns or custom sections are needed beyond the current system, they can be added by development. This ensures scalability without compromising design quality.

---

## File Structure & CSS Strategy

CSS is modular and categorized for clarity:

```
assets/css/
├── 01-base/                 ← Global styles (reset, layout, helpers)
│   ├── _reset.scss
│   ├── _global.scss
│   ├── _layout.scss
│   ├── _forms.scss
│   └── _index.scss          ← Front-end entry point
├── editor.scss              ← Imports only editor-relevant styles
├── frontend.scss            ← Main front-end stylesheet
├── blocks/                  ← Per-block styles (optional)
│   └── core/
│       ├── paragraph.min.css
│       └── image.min.css
```

To manage shared styles between front-end and editor:

* `and` selectively import from `01-base/`.
* This avoids needing to reorganize CSS folders by usage context and keeps responsibility modular.

---

## Editor Style Integration

Editor styles are enqueued using `enqueue_block_editor_assets` for full control and better integration with build pipelines. This allows for SCSS compilation, dependency management, and conditional loading based on environment or block use.

---

## Block Patterns & Reuse

* The theme provides **predefined Block Patterns** for common layout sections.
* Patterns include semantic structure, spacing rules, and styling presets.
* These patterns serve as the primary method for creating new content layouts, reducing the need for one-off styling.

---

## Front-End-Only Styles

Some layout behaviors only make sense on the front end (e.g., first/last child margin corrections, comment visibility, page-template-specific rules). These are **not loaded in the editor** to avoid unnecessary complexity.

Examples:

```scss
.entry-content > *:first-child { margin-block-start: 0 !important; }
.page-template-no-title :where(.wp-site-blocks) > * { margin-block-start: 0; }
.wp-block-group.entry-comments:empty { display: none; }
```

---

## When Development is Needed

Although the theme supports flexible content creation, truly new layout systems, visual elements, or patterns require development. This ensures:

* New design elements are consistent with the system.
* CSS and theme.json tokens are reused.
* Editor experience stays clean and easy to use.

---

## Summary

This theme is designed to:

* **Empower editors** to create rich layouts safely.
* **Reduce development overhead** through reuse and clear structure.
* **Support long-term growth** by evolving the system, not bypassing it.

---
