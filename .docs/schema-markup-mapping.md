# Schema.org / Microdata Mapping — Legal Services Websites

**Project scope:** Define possible schema.org types and properties per page type to support SEO (traditional search) and GEO (Generative Engine Optimization — how AI systems parse, extract, and cite entities). This is a structured-data reference, not a content deliverable.

---

## 1. Core Pages

### Homepage
- `Organization` or `LegalService` (root entity for the client/firm)
  - `name`, `logo`, `url`, `sameAs` (social profiles, GBP, bar directories), `contactPoint`, `areaServed`
  - If multi-location: use `LegalService` with `hasOfferCatalog`, or represent each location as a `LocalBusiness`/`LegalService` node linked via `parentOrganization` / `department` / `subOrganization`
- `WebSite` — with `SearchAction` (sitelinks search box eligibility)
- `AggregateRating` / `Review` — if the Reviews component is present, attached to the `Organization`/`LegalService` entity
- `BreadcrumbList`

### About Us page
- `AboutPage`
- `Organization` — `foundingDate`, `founder`, `award`, `knowsAbout` (practice areas, useful for GEO topical association)
- `BreadcrumbList`

### Team page
- `CollectionPage` or `ItemList`
- `itemListElement` → array of `Person` (attorneys)
- `BreadcrumbList`

### Team member single page
- `Person`
  - `name`, `jobTitle`, `image`, `worksFor`, `alumniOf`, `award`, `memberOf` (bar associations), `knowsLanguage`, `sameAs` (bar profile, LinkedIn, Avvo, Justia, etc.)
- `BreadcrumbList`

### Contact page
- `ContactPage`
- `ContactPoint` (or full `LocalBusiness` address block if it's the office contact)
- `BreadcrumbList`

### Thank you page
- `WebPage` (generic) — typically `noindex`; minimal/no structured data needed

### Search results page
- `SearchResultsPage`
- `BreadcrumbList`

### 404 page
- `WebPage` (generic) — `noindex`; no structured data needed

---

## 2. Legal Services

### Legal services hub
- `CollectionPage` or `ItemList`
- `itemListElement` → array referencing each `Service`/`LegalService`
- `BreadcrumbList`

### Legal service single page
- `Service` or `LegalService`
  - `name`, `serviceType`, `description`, `provider` (→ `Organization`/`Attorney`), `areaServed`
- `FAQPage` — if the FAQ section is active on this page (`mainEntity`: array of `Question`/`Answer`)
- `AggregateRating` / `Review` — if Reviews component present
- `BreadcrumbList`

### Legal sub-service single page
- Same structure as above
- `isPartOf` → relation to parent `Service`/`LegalService`

### Legal service + Location combo page
- `LegalService`
  - `areaServed` set to the specific city/region (this is the key differentiator vs. the plain service page)
  - `provider` → linking back to the location's `LocalBusiness` entity
- `FAQPage` — if present
- `BreadcrumbList`
- *Flag:* content/entity relationships here need care to avoid this reading as a near-duplicate of the plain service page and plain location page in structured data too, not just in copy

---

## 3. Locations

### Location page
- `LegalService` or `Attorney` as subtype of `LocalBusiness`
  - `address` (`PostalAddress`), `geo` (`GeoCoordinates`), `telephone`, `openingHoursSpecification`, `areaServed`, `priceRange`
- `AggregateRating` / `Review` — if Reviews component present
- `BreadcrumbList`

---

## 4. Content & Resources

### Blog (all articles)
- `Blog` or `CollectionPage`
- `ItemList` of `BlogPosting`
- `BreadcrumbList`

### Single post view
- `BlogPosting` or `Article`
  - `headline`, `author` (`Person`/`Organization`), `datePublished`, `dateModified`, `image`, `publisher`
- `FAQPage` — if applicable
- `BreadcrumbList`

### Archive by category
- `CollectionPage`
- `BreadcrumbList`

### Resources/Guides page
- `CollectionPage` or `ItemList`
- Individual guides: `Article` (schema.org has no dedicated "Guide" type; `Article` or `LearningResource` are the closest fits)
- `BreadcrumbList`

### FAQ page (dedicated)
- `FAQPage`
  - `mainEntity` → array of `Question`, each with `acceptedAnswer` (`Answer`)

---

## 5. Legal / Compliance

### Privacy Policy / Terms of Service
- `WebPage` (generic) — schema.org has no dedicated policy-document type
- `BreadcrumbList`

---

## 6. Reusable Components — Structured Data Notes

These don't get their own page-level type; they attach to whichever page they appear on.

| Component | Schema approach |
|---|---|
| **FAQ section** | Nest a `FAQPage` block (or `mainEntity` array) into the host page's markup, in addition to whatever the page's primary type is |
| **Reviews component** | `AggregateRating` + individual `Review` nodes, attached to the relevant `LocalBusiness`/`LegalService`/`Organization` entity on that page |
| **Case results component** | ⚠️ **Gap:** schema.org has no dedicated type for verdicts/settlements. Options: omit structured data and rely on well-marked-up plain content, or approximate loosely with `ItemList` + `MonetaryAmount` per result — not a clean fit either way. Worth a deliberate decision rather than a default. |

---

## GEO-specific considerations (beyond standard SEO schema)

- **Entity clarity**: consistent `sameAs` linking across pages (GBP, bar association directories, Avvo, Justia, LinkedIn) helps AI systems disambiguate and trust the entity
- **`knowsAbout`**: useful on `Organization`/`Person` to explicitly associate practice areas/topics
- **`Question`/`Answer` pairs**: FAQ structured data is one of the highest-value formats for AI Overviews and LLM citation — worth prioritizing across service, location, and combo pages, not just a standalone FAQ page
- **`speakable`**: optional property marking sections suited for voice/AI readout — worth testing on service/location pages
- **E-E-A-T signals**: `author`, `reviewedBy`, credentials on `Person` (attorneys) feed both SEO trust signals and GEO source-credibility evaluation
- **Consistency over volume**: AI systems appear to weight consistent, non-contradictory entity data across a domain more than the sheer amount of markup — worth deciding on canonical property values (e.g. one canonical `areaServed` phrasing) before scaling markup across combo pages
