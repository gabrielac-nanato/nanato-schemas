# PHP Conventions — nanato-schemas

## Standard & tooling
- WordPress Coding Standards (WPCS) via `phpcs`/`phpcbf` (`composer run lint` / `composer run format`), configured in `phpcs.xml.dist`.
- 4-space indentation (not tabs), matching the org-wide convention — this differs from WPCS's default tab preference; keep `phpcs.xml.dist` explicit about the exception when it's written.
- Short array syntax (`[]`, not `array()`).
- Non-Yoda conditions (`$value === true`, not `true === $value`).
- English-only identifiers: variables, functions, classes, constants, comments.

## Autoloading & file layout
- Composer PSR-4: `Nanato_Schemas\` → `classes/` (see `composer.json`).
- PSR-4 requires the file name to match the class name exactly — this overrides WordPress's traditional `class-my-thing.php` file-naming convention, since the two are incompatible. One file per class.
- Class names: `Studly_Case_With_Underscores` (e.g. `Schema_Builder`, `Organization_Schema`, `Acf_Field_Map`), matching file `classes/Schema_Builder.php`.
- Namespace classes by schema layer where it clarifies intent, e.g. `Nanato_Schemas\Global_Layer`, `Nanato_Schemas\Page_Layer`, `Nanato_Schemas\Components` — don't force a namespace split before a second class in that layer actually exists.
- Plain functions (hooks, helpers not tied to a class) stay in procedural includes under `inc/`, auto-loaded via `glob()` from the main plugin file — same pattern as the parent theme's `functions.php`. Function names: `nanato_schemas_snake_case()`.
- Constants: `NANATO_SCHEMAS_SNAKE_CASE`.

## WordPress integration
- Prefix all hooks, options, transients, and meta keys with `nanato_schemas_`.
- All filterable: every JSON-LD fragment/graph node the plugin outputs must run through a corresponding `apply_filters( 'nanato_schemas_...', ... )` before output (per the project's "all schema output should be filterable" convention in `CLAUDE.md`).
- Escape/sanitize per WPCS at the point of output — `esc_html`, `esc_url`, `esc_attr`, `wp_kses_post`, `absint`, etc. JSON-LD blocks are built as PHP arrays and passed through `wp_json_encode()` at the very end, not string-concatenated.
- Validate ACF field data defensively where a required field can plausibly be empty — return early (no output) rather than emitting incomplete/invalid JSON-LD. Prefer an HTML comment noting what's missing over a fatal error, matching the parent theme's section-partial pattern.

## Style
- No premature abstraction: don't introduce an interface, factory, or base class until there are at least two concrete implementations that need it.
- No defensive error handling for conditions that can't occur (e.g. don't null-check a value ACF guarantees is set when the field group is present) — validate only at real boundaries (ACF field values, external API responses).
- Docblocks: one-line `@param`/`@return` blocks on public class methods and hook callbacks; skip docblocks on obvious private helpers where the signature is self-explanatory. No `@since` tags.
- No comments explaining *what* the code does — only *why*, when a decision is non-obvious (e.g. why a given schema.org approximation was chosen over another, referencing the relevant Open Gap in `CLAUDE.md`).

## Status
This is a first draft — revisit once the first class actually lands (`Nanato_Schemas\` autoload root and `classes/` directory don't exist yet). Treat naming and layer-namespacing as provisional until then.
