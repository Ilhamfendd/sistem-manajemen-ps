# CSS Design System Documentation

## Overview

Updated comprehensive CSS with **standardized spacing, consistent colors, and design tokens** across all pages.

---

## Color Palette

### Primary Colors

- **Primary**: `#1f6feb` (Blue)
- **Primary Dark**: `#1558c5` (Dark Blue)
- **Primary Light**: `#e8f1ff` (Light Blue background)

### Status Colors

- **Success**: `#28a745` (Green)
- **Danger**: `#dc3545` (Red)
- **Warning**: `#ffc107` (Yellow)
- **Info**: `#17a2b8` (Cyan)

### Neutral Colors

- **Dark**: `#333333` (Text)
- **Medium**: `#666666` (Secondary text)
- **Light**: `#f8f9fa` (Background)
- **Border**: `#e0e0e0` (Borders)
- **White**: `#ffffff`

---

## Spacing Scale (Consistent Throughout)

```css
--spacing-xs:  4px    (very small gaps)
--spacing-sm:  8px    (small gaps)
--spacing-md:  12px   (medium gaps)
--spacing-lg:  16px   (standard padding)
--spacing-xl:  20px   (large padding)
--spacing-2xl: 24px   (extra large)
--spacing-3xl: 30px   (page margins)
--spacing-4xl: 40px   (large sections)
```

**Usage**: All components use these scales for consistent spacing.

---

## Border Radius Scale

```css
--radius-sm:  6px   (small radius - inputs, buttons)
--radius-md:  8px   (medium radius - common)
--radius-lg:  12px  (large radius - cards)
--radius-xl:  15px  (extra large - modals, headers)
```

---

## Shadow Scale

```css
--shadow-sm: 0 2px 8px rgba(0, 0, 0, 0.06)       (subtle)
--shadow-md: 0 4px 12px rgba(0, 0, 0, 0.1)       (normal)
--shadow-lg: 0 8px 24px rgba(0, 0, 0, 0.12)      (prominent)
```

---

## Transition Timing

```css
--transition-fast:   0.2s ease  (quick interactions)
--transition-normal: 0.3s ease  (standard animations)
--transition-slow:   0.5s ease  (smooth transitions)
```

---

## Component Spacing

### Navbar

- **Height**: 65px
- **Padding**: `var(--spacing-lg)` (16px) horizontal
- **Gap**: `var(--spacing-lg)` (16px) between items

### Sidebar

- **Width**: 260px
- **Header Padding**: `var(--spacing-lg)` (16px)
- **Section Padding**: `var(--spacing-lg)` top/bottom
- **Item Padding**: `var(--spacing-md)` horizontal (12px)
- **Title Padding**: `var(--spacing-md)` (12px)

### Main Content

- **Top Margin**: 65px (navbar height)
- **Left Margin**: 260px (sidebar width)
- **Page Padding**: `var(--spacing-3xl)` (30px)
- **Mobile Padding**: `var(--spacing-xl)` (20px)
- **Small Mobile**: `var(--spacing-lg)` (16px)

### Cards

- **Padding**: `var(--spacing-2xl)` (24px)
- **Border Radius**: `var(--radius-lg)` (12px)
- **Margin Bottom**: `var(--spacing-2xl)` (24px)
- **Shadow**: `var(--shadow-sm)` (subtle)
- **Hover Shadow**: `var(--shadow-md)` (elevated)

### Buttons

- **Padding**: `var(--spacing-sm)` vertical, `var(--spacing-lg)` horizontal
- **Small**: `var(--spacing-xs)` vertical, `var(--spacing-md)` horizontal
- **Large**: `var(--spacing-lg)` vertical, `var(--spacing-2xl)` horizontal
- **Border Radius**: `var(--radius-md)` (8px)

### Forms

- **Group Margin**: `var(--spacing-lg)` (16px)
- **Label Margin**: `var(--spacing-md)` (12px)
- **Input Padding**: `var(--spacing-md)` (12px)
- **Input Border Radius**: `var(--radius-md)` (8px)

### Tables

- **Header Padding**: `var(--spacing-lg)` (16px)
- **Cell Padding**: `var(--spacing-lg)` (16px)
- **Row Gap**: 1px border
- **Responsive**: Border radius on first/last cells

---

## Utility Classes

### Spacing

```html
<!-- Margin -->
<div class="m-1">
	<!-- margin: 4px -->
	<div class="m-4">
		<!-- margin: 16px -->
		<div class="mt-5">
			<!-- margin-top: 20px -->
			<div class="mb-3">
				<!-- margin-bottom: 12px -->

				<!-- Padding -->
				<div class="p-3">
					<!-- padding: 12px -->
					<div class="p-6">
						<!-- padding: 24px -->
						<div class="pt-4">
							<!-- padding-top: 16px -->
							<div class="pb-5"><!-- padding-bottom: 20px --></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
```

### Colors

```html
<div class="text-primary">
	<!-- Primary color text -->
	<div class="text-success">
		<!-- Success color text -->
		<div class="text-danger">
			<!-- Danger color text -->
			<div class="bg-primary">
				<!-- Primary background -->
				<div class="bg-light"><!-- Light background --></div>
			</div>
		</div>
	</div>
</div>
```

### Layout

```html
<div class="d-flex">
	<!-- display: flex -->
	<div class="d-flex gap-3">
		<!-- flex + gap -->
		<div class="justify-content-between">
			<!-- flex-spacing -->
			<div class="align-items-center"><!-- vertical align --></div>
		</div></div
	>
</div>
```

### Border & Shadow

```html
<div class="rounded">
	<!-- 8px radius -->
	<div class="rounded-lg">
		<!-- 12px radius -->
		<div class="shadow-sm">
			<!-- subtle shadow -->
			<div class="shadow-md"><!-- medium shadow --></div>
		</div>
	</div>
</div>
```

### Text

```html
<div class="text-center">
	<!-- text-align: center -->
	<div class="font-weight-bold">
		<!-- font-weight: 700 -->
		<div class="text-lg"><!-- font-size: 16px --></div>
	</div>
</div>
```

---

## Dark Mode

All components automatically support dark mode via CSS variables and `body.dark-mode` selector.

### Dark Mode Colors

- **Background**: `linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%)`
- **Navbar**: `linear-gradient(135deg, #0d1b2a 0%, #1a2332 100%)`
- **Sidebar**: `#1e1e1e`
- **Cards**: `#242424`
- **Input**: `#2a2a2a`
- **Text**: `#e0e0e0`
- **Border**: `#333`

### Dark Mode Transitions

All colors automatically adjust when `.dark-mode` class is applied to `body`.

---

## Component Examples

### Consistent Card Layout

```html
<div class="card">
	<h3 class="mb-3">Title</h3>
	<p class="mb-4">Content with spacing</p>
	<div class="btn-group">
		<a href="#" class="btn btn-primary">Action</a>
	</div>
</div>
```

### Consistent Form Layout

```html
<form>
	<div class="form-group">
		<label for="name">Name</label>
		<input type="text" id="name" placeholder="Enter name" />
	</div>

	<div class="form-group">
		<label for="email">Email</label>
		<input type="email" id="email" placeholder="Enter email" />
	</div>

	<div class="btn-group">
		<button type="submit" class="btn btn-primary">Save</button>
		<a href="#" class="btn btn-secondary">Cancel</a>
	</div>
</form>
```

### Consistent Table Layout

```html
<div class="table-container">
	<table>
		<thead>
			<tr>
				<th>Column 1</th>
				<th>Column 2</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>Data 1</td>
				<td>Data 2</td>
			</tr>
		</tbody>
	</table>
</div>
```

### Consistent Alert Layout

```html
<div class="alert alert-success mb-4">
	<h4><i class="fas fa-check"></i> Success!</h4>
	<p class="mb-0">Your action was successful.</p>
</div>
```

---

## Responsive Breakpoints

### Large Screens (> 1200px)

- Sidebar: 260px
- Padding: 30px

### Tablets (768px - 1200px)

- Sidebar: toggleable (hamburger menu)
- Padding: 20px
- Grid: Adjusted columns

### Mobile (< 768px)

- Sidebar: Full width (off-canvas)
- Padding: 16px
- Grid: Single column
- Font sizes: Reduced by 10-15%

### Small Mobile (< 480px)

- Padding: 12px
- Card padding: 16px
- Font sizes: Further reduced
- Table: Horizontal scroll

---

## Migration Guide

### Before (Old Spacing)

```css
.card {
	padding: 25px;
	margin-bottom: 25px;
}
```

### After (New Spacing)

```css
.card {
	padding: var(--spacing-2xl); /* 24px */
	margin-bottom: var(--spacing-2xl); /* 24px */
}
```

### Benefits

- ✅ Consistent across all pages
- ✅ Easier to update globally
- ✅ Better responsive support
- ✅ Professional appearance
- ✅ Improved dark mode support

---

## Performance Improvements

- CSS variables for efficient color/spacing changes
- Unified shadow system (only 3 types)
- Optimized transitions (3 speed options)
- Standardized border radius (4 options)
- Better browser support

---

## Browser Support

- Chrome: ✅ Full support
- Firefox: ✅ Full support
- Safari: ✅ Full support
- Edge: ✅ Full support
- IE 11: ⚠️ CSS variables not supported (degraded)

---

## Future Enhancements

1. **CSS Grid System**: Consider custom 12-column grid
2. **Animation Library**: Standardized animations
3. **Component Library**: Reusable component classes
4. **Theme Switcher**: Multiple color schemes
5. **Accessibility**: WCAG 2.1 AA compliance

---

## Testing Checklist

- [ ] Light mode renders correctly on all pages
- [ ] Dark mode renders correctly on all pages
- [ ] Spacing consistent across all components
- [ ] Colors match design system on all pages
- [ ] Responsive on mobile (768px and below)
- [ ] Responsive on tablet (768px - 1024px)
- [ ] Buttons have proper hover/focus states
- [ ] Forms have proper focus states
- [ ] Tables display correctly on mobile
- [ ] Alerts/Modals render properly
- [ ] Dark mode persists across page refreshes

---

**Last Updated**: Current Session  
**Version**: 1.0  
**Status**: Production Ready
