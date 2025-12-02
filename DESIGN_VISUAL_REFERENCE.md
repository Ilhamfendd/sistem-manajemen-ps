# Design System Visual Reference Guide

## Color Swatches

### Primary Colors

```
Primary Blue       #1f6feb  ████████████████████ Professional
Primary Dark       #1558c5  ████████████████████ Bold
Primary Light      #e8f1ff  ████████████████████ Subtle BG
```

### Status Colors

```
Success Green      #28a745  ████████████████████ Positive
Danger Red         #dc3545  ████████████████████ Error
Warning Yellow     #ffc107  ████████████████████ Caution
Info Cyan          #17a2b8  ████████████████████ Information
```

### Neutral Colors

```
Text Dark          #333333  ████████████████████ Main Text
Secondary Gray     #666666  ████████████████████ Secondary
Light Gray         #f8f9fa  ████████████████████ Background
Border Gray        #e0e0e0  ████████████████████ Borders
Pure White         #ffffff  ████████████████████ Cards
```

### Dark Mode Colors

```
Dark BG            #1a1a1a  ████████████████████ Primary BG
Navbar Dark        #0d1b2a  ████████████████████ Header
Sidebar Dark       #1e1e1e  ████████████████████ Navigation
Card Dark          #242424  ████████████████████ Content
Input Dark         #2a2a2a  ████████████████████ Inputs
Text Light         #e0e0e0  ████████████████████ Text
Border Dark        #333333  ████████████████████ Borders
```

---

## Spacing Scale Visualization

### XS (4px)

```
|  |
  4px
```

### SM (8px)

```
|      |
   8px
```

### MD (12px)

```
|           |
    12px
```

### LG (16px)

```
|                |
     16px
```

### XL (20px)

```
|                    |
       20px
```

### 2XL (24px)

```
|                        |
         24px
```

### 3XL (30px)

```
|                              |
            30px
```

### 4XL (40px)

```
|                                        |
                 40px
```

---

## Component Spacing Examples

### Card Component

```
┌─────────────────────────────────────────┐
│  ●●●●●●●●●●●●●●●●●●●●●●●●●●●●●●●●●  │
│  ●                               ●     │  ← 24px (padding)
│  ● Title                          ●    │
│  ●                               ●     │
│  ●●●●●●●●●●●●●●●●●●●●●●●●●●●●●●●●●  │  ← 24px (margin-bottom)
└─────────────────────────────────────────┘
```

### Button Spacing

```
┌──────────────────────┐
│  ▁▁▁ Button ▁▁▁      │  ← 8px (vert padding)
│ ▁                   ▁ │  ← 16px (horiz padding)
└──────────────────────┘

┌─────────────────────────────────────┐
│ ┌──────┐    ┌──────┐    ┌──────┐   │
│ │ Btn1 │ ▁▁ │ Btn2 │ ▁▁ │ Btn3 │   │  ← 8px gap between buttons
│ └──────┘    └──────┘    └──────┘   │
└─────────────────────────────────────┘
```

### Form Group Spacing

```
┌────────────────────────────┐
│ Label                      │  ← title
│ ▁ ▁ ▁ ▁ ▁ ▁ ▁ ▁ ▁ (6px)   │
│ ┌──────────────────────┐   │
│ │ Input Field          │   │
│ └──────────────────────┘   │  ← 16px (form-group margin-bottom)
│ ▁ ▁ ▁ ▁ ▁ ▁ ▁ ▁ ▁        │
│ Label                      │
│ ▁ ▁ ▁ ▁ ▁ ▁ ▁ ▁ ▁ (6px)   │
│ ┌──────────────────────┐   │
│ │ Input Field          │   │
│ └──────────────────────┘   │
└────────────────────────────┘
```

### Table Spacing

```
┌─────────────────────────────────────────────┐
│ ┌───────────────────────────────────────┐   │
│ │ Header 1  ▁ Header 2  ▁ Header 3     │   │  ← 16px (header padding)
│ ├───────────────────────────────────────┤   │
│ │ Data 1    ▁ Data 2    ▁ Data 3       │   │  ← 16px (cell padding)
│ ├───────────────────────────────────────┤   │
│ │ Data 1    ▁ Data 2    ▁ Data 3       │   │
│ ├───────────────────────────────────────┤   │
│ │ Data 1    ▁ Data 2    ▁ Data 3       │   │
│ └───────────────────────────────────────┘   │
└─────────────────────────────────────────────┘
```

---

## Border Radius Scale

### SM (6px)

```
╭─────╮
│     │  Slightly rounded
╰─────╯
```

### MD (8px)

```
╭──────╮
│      │  Medium rounded
╰──────╯
```

### LG (12px)

```
╭───────╮
│       │  Large rounded
╰───────╯
```

### XL (15px)

```
╭────────╮
│        │  Extra large rounded
╰────────╯
```

---

## Shadow System

### Shadow SM (subtle)

```
┌──────────────┐
│              │
│   Card       │
│              │
└──────────────┘
   ▔▔▔▔▔▔▔▔▔▔▔▔  (light shadow)
```

### Shadow MD (normal)

```
┌──────────────┐
│              │
│   Card       │
│              │
└──────────────┘
  ▔▔▔▔▔▔▔▔▔▔▔▔▔▔  (medium shadow)
```

### Shadow LG (prominent)

```
┌──────────────┐
│              │
│   Card       │
│              │
└──────────────┘
 ▔▔▔▔▔▔▔▔▔▔▔▔▔▔▔▔ (larger shadow)
```

---

## Typography Scale

### Text Sizes

```
12px  ← text-sm    (small labels)
14px  ← text-base  (regular text)
16px  ← text-lg    (emphasized)
18px  ← text-xl    (headings)
24px  ← h2         (page titles)
28px  ← h1         (main title)
```

### Font Weights

```
400   ← font-weight-normal    (Regular text)
600   ← font-weight-semibold  (Emphasis)
700   ← font-weight-bold      (Strong emphasis)
```

---

## Responsive Breakpoints

### Desktop (> 1200px)

```
┌─────────────────────────────────────────────────────┐
│ ┌───┐ ┌───────────────────────────────────────────┐ │
│ │   │ │ Main Content                              │ │
│ │ S │ │                                           │ │
│ │ I │ │ Full Width                                │ │
│ │ D │ │ 30px padding                              │ │
│ │ E │ │                                           │ │
│ │ B │ ├───────────────────────────────────────────┤ │
│ │ A │ │ More Content                              │ │
│ │ R │ │                                           │ │
│ │   │ └───────────────────────────────────────────┘ │
│ └───┘                                               │
│      260px                                          │
└─────────────────────────────────────────────────────┘
      1400px max-width
```

### Tablet (768px - 1200px)

```
┌──────────────────────────────────┐
│ ☰ ┌──────────────────────────┐  │
│   │ Main Content             │  │
│   │ Responsive 20px padding  │  │
│   │ Sidebar toggleable       │  │
│   ├──────────────────────────┤  │
│   │ Content below            │  │
│   │                          │  │
│   └──────────────────────────┘  │
└──────────────────────────────────┘
       768px
```

### Mobile (< 768px)

```
┌───────────────────┐
│ ☰                 │
│ ┌───────────────┐ │
│ │ Content       │ │
│ │ 16px padding  │ │
│ │ Single col    │ │
│ ├───────────────┤ │
│ │ More Content  │ │
│ │ Full Width    │ │
│ └───────────────┘ │
└───────────────────┘
      < 768px
```

---

## Button Variants

### Primary Button

```
┌────────────────────┐
│ ▓▓▓▓▓▓ Action ▓▓▓▓ │  ← Blue gradient
│ (Hover: raised up) │
└────────────────────┘
```

### Secondary Button

```
┌────────────────────┐
│ ░░░░░░ Cancel ░░░░ │  ← Gray
│ (Hover: darker)    │
└────────────────────┘
```

### Danger Button

```
┌────────────────────┐
│ ███████ Delete ███ │  ← Red
│ (Hover: raised)    │
└────────────────────┘
```

### Success Button

```
┌────────────────────┐
│ ██████ Approve ██ │  ← Green
│ (Hover: raised)    │
└────────────────────┘
```

---

## Alert Styles

### Success Alert

```
┌─ ✓ ─────────────────────────────────────┐
│ Success Message                         │ ← Green border left
│ Your action was completed successfully. │
└─────────────────────────────────────────┘
Background: light green
```

### Danger Alert

```
┌─ ✕ ─────────────────────────────────────┐
│ Error Message                           │ ← Red border left
│ Something went wrong. Please try again. │
└─────────────────────────────────────────┘
Background: light red
```

### Warning Alert

```
┌─ ⚠ ─────────────────────────────────────┐
│ Warning Message                         │ ← Yellow border left
│ Please note this important information. │
└─────────────────────────────────────────┘
Background: light yellow
```

### Info Alert

```
┌─ ℹ ─────────────────────────────────────┐
│ Information Message                     │ ← Cyan border left
│ This is an informational message.       │
└─────────────────────────────────────────┘
Background: light cyan
```

---

## Form Elements

### Input Focus State

```
Normal:          Focused:
┌──────────────┐ ┌──────────────────────┐
│              │ │ [focus glow]         │
│ Input Field  │ │ Input Field          │
│              │ │ [blue focus outline] │
└──────────────┘ └──────────────────────┘
```

### Validation States

```
Valid Input:             Invalid Input:
┌──────────────┐         ┌──────────────┐
│ ✓            │         │ ✕            │
│ Email        │         │ Email        │
└──────────────┘         └──────────────┘
Green border            Red border
```

---

## Dark Mode Comparison

### Light Mode

```
┌──────────────────────────────────┐
│ [Light Navbar - Blue]            │
├──────────┬──────────────────────┤
│ Sidebar  │ Main Content         │
│ [White]  │ [Light Gray]         │
│          │ ┌──────────────────┐ │
│ • Item 1 │ │ [White Card]     │ │
│ • Item 2 │ │ Dark Text        │ │
│ • Item 3 │ └──────────────────┘ │
│          │                      │
└──────────┴──────────────────────┘
```

### Dark Mode

```
┌──────────────────────────────────┐
│ [Dark Navbar - Navy]             │
├──────────┬──────────────────────┤
│ Sidebar  │ Main Content         │
│ [#1e1e]  │ [Dark Gray Gradient] │
│          │ ┌──────────────────┐ │
│ • Item 1 │ │ [#242424 Card]   │ │
│ • Item 2 │ │ Light Text       │ │
│ • Item 3 │ └──────────────────┘ │
│          │                      │
└──────────┴──────────────────────┘
```

---

## Grid Layout Examples

### 4 Column Grid (Desktop)

```
┌─────┬─────┬─────┬─────┐
│ KPI │ KPI │ KPI │ KPI │ ← 4 cards per row, 16px gap
├─────┼─────┼─────┼─────┤
│ KPI │ KPI │ KPI │ KPI │
└─────┴─────┴─────┴─────┘
```

### 2 Column Grid (Tablet)

```
┌──────────┬──────────┐
│   KPI    │   KPI    │ ← 2 cards per row, 16px gap
├──────────┼──────────┤
│   KPI    │   KPI    │
└──────────┴──────────┘
```

### 1 Column Grid (Mobile)

```
┌──────────────────┐
│      KPI         │ ← 1 card per row
├──────────────────┤
│      KPI         │
├──────────────────┤
│      KPI         │
├──────────────────┤
│      KPI         │
└──────────────────┘
```

---

## Quick Reference

### Most Used Spacing Values

```
Component Margins:    16px (var(--spacing-lg))
Component Padding:    24px (var(--spacing-2xl))
Page Padding:         30px (var(--spacing-3xl))
Element Gaps:         16px (var(--spacing-lg))
Form Groups:          16px (var(--spacing-lg))
```

### Most Used Colors

```
Primary Action:       #1f6feb (blue)
Success State:        #28a745 (green)
Error State:          #dc3545 (red)
Background:           #f8f9fa (light) / #242424 (dark)
Text Primary:         #333333 (light) / #e0e0e0 (dark)
```

### Most Used Radius

```
Buttons:              8px (var(--radius-md))
Cards:                12px (var(--radius-lg))
Inputs:               8px (var(--radius-md))
Modals:               15px (var(--radius-xl))
```

---

## Implementation Checklist

- [x] Color palette defined
- [x] Spacing scale implemented
- [x] Border radius system created
- [x] Shadow hierarchy established
- [x] Utility classes added
- [x] Dark mode support
- [x] Responsive design
- [x] Component examples documented
- [ ] Team training (pending)
- [ ] User feedback collection (pending)

---

**Version**: 1.0  
**Last Updated**: November 30, 2025  
**Status**: Production Ready  
**Designer Notes**: All values are CSS variables for easy customization
