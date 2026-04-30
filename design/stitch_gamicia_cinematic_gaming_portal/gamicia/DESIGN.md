---
name: GAMICIA
colors:
  surface: '#131313'
  surface-dim: '#131313'
  surface-bright: '#3a3939'
  surface-container-lowest: '#0e0e0e'
  surface-container-low: '#1c1b1b'
  surface-container: '#201f1f'
  surface-container-high: '#2a2a2a'
  surface-container-highest: '#353534'
  on-surface: '#e5e2e1'
  on-surface-variant: '#e6beb2'
  inverse-surface: '#e5e2e1'
  inverse-on-surface: '#313030'
  outline: '#ad897e'
  outline-variant: '#5c4037'
  surface-tint: '#ffb59e'
  primary: '#ffb59e'
  on-primary: '#5e1700'
  primary-container: '#ff571a'
  on-primary-container: '#521300'
  inverse-primary: '#ae3200'
  secondary: '#ffb77f'
  on-secondary: '#4e2600'
  secondary-container: '#ff8a00'
  on-secondary-container: '#613100'
  tertiary: '#c8c6c5'
  on-tertiary: '#313030'
  tertiary-container: '#929090'
  on-tertiary-container: '#2a2a2a'
  error: '#ffb4ab'
  on-error: '#690005'
  error-container: '#93000a'
  on-error-container: '#ffdad6'
  primary-fixed: '#ffdbd0'
  primary-fixed-dim: '#ffb59e'
  on-primary-fixed: '#3a0b00'
  on-primary-fixed-variant: '#852400'
  secondary-fixed: '#ffdcc4'
  secondary-fixed-dim: '#ffb77f'
  on-secondary-fixed: '#2f1500'
  on-secondary-fixed-variant: '#6f3900'
  tertiary-fixed: '#e5e2e1'
  tertiary-fixed-dim: '#c8c6c5'
  on-tertiary-fixed: '#1c1b1b'
  on-tertiary-fixed-variant: '#474746'
  background: '#131313'
  on-background: '#e5e2e1'
  surface-variant: '#353534'
typography:
  display-xl:
    fontFamily: Space Grotesk
    fontSize: 72px
    fontWeight: '700'
    lineHeight: '1.1'
    letterSpacing: -0.04em
  headline-lg:
    fontFamily: Space Grotesk
    fontSize: 48px
    fontWeight: '700'
    lineHeight: '1.2'
    letterSpacing: -0.02em
  headline-md:
    fontFamily: Space Grotesk
    fontSize: 32px
    fontWeight: '600'
    lineHeight: '1.3'
  body-lg:
    fontFamily: Inter
    fontSize: 18px
    fontWeight: '400'
    lineHeight: '1.6'
  body-md:
    fontFamily: Inter
    fontSize: 16px
    fontWeight: '400'
    lineHeight: '1.6'
  label-caps:
    fontFamily: Space Grotesk
    fontSize: 14px
    fontWeight: '700'
    lineHeight: '1'
    letterSpacing: 0.15em
spacing:
  unit: 8px
  container-max: 1440px
  gutter: 24px
  margin-page: 64px
  stack-sm: 16px
  stack-md: 32px
  stack-lg: 64px
---

## Brand & Style
The design system is engineered to evoke the high-octane atmosphere of AAA gaming titles. It targets an audience of enthusiasts who demand high-fidelity visuals and immersive digital environments. The aesthetic sits at the intersection of **Cinematic Glassmorphism** and **High-Contrast Boldness**. 

The interface should feel like a premium "heads-up display" (HUD) overlaying a cinematic world. It utilizes deep blacks to create infinite depth, punctuated by concentrated light sources and fiery atmospheric glows that guide the user's focus toward primary actions.

## Colors
The palette is rooted in a "Void Black" foundation to maximize the dynamic range of the accent colors. 

- **Primary:** A fiery, aggressive red-orange used for critical calls to action and primary navigation states.
- **Secondary:** A glowing amber used for highlights, secondary interactions, and status indicators.
- **Surface Palette:** Layers of deep charcoal and matte black create a sense of structural depth.
- **Accent Glows:** Linear gradients and radial blurs using the primary and secondary colors should be applied sparingly to simulate cinematic lighting hitting the edges of UI glass.

## Typography
This design system utilizes **Space Grotesk** for headlines and labels to deliver a wide, technical, and cutting-edge feel characteristic of modern sci-fi and action gaming. For the logo 'GAMICIA', use Space Grotesk Bold with tight tracking.

**Inter** is employed for body copy to ensure maximum legibility against dark, textured backgrounds. Large display text should be treated as a visual element, often using subtle gradients or outer glows to mimic illuminated signage.

## Layout & Spacing
The layout follows a **12-column fixed grid** with generous margins to allow the cinematic background imagery to breathe. Spacing is governed by an 8px modular scale, emphasizing verticality and rhythm. 

Use wide gutters to prevent the UI from feeling cluttered, maintaining the "HUD" aesthetic where components appear to float over the content. Sections should be separated by significant vertical padding (64px+) to create a distinct narrative flow as the user scrolls.

## Elevation & Depth
Depth is the primary driver of hierarchy in this design system. It is achieved through:
- **Glassmorphism:** All containers use a `backdrop-filter: blur(20px)` with a semi-transparent charcoal fill (approx 40-60% opacity).
- **Rim Lighting:** Instead of traditional shadows, use 1px inner borders (strokes) with a top-down gradient to simulate light hitting the top edge of a physical panel.
- **Atmospheric Glows:** High-elevation elements (like active modals or primary buttons) should cast a soft, colored radial glow (Primary Red-Orange) behind them, rather than a black drop shadow.
- **Parallax:** UI layers should move at slightly different speeds than background media to reinforce the 3D space.

## Shapes
The design system utilizes **Sharp (0px)** corners for a more aggressive, technical, and industrial appearance. This reinforces the "hard-surface" modeling aesthetic common in AAA game design. Any exceptions should be strictly reserved for circular icons or profile avatars. All structural panels, buttons, and input fields must maintain 90-degree angles to preserve the rigid, architectural feel of the brand.

## Components
- **Buttons:** Rectangular with no radius. Primary buttons feature a solid fiery orange-to-red gradient with a white "Label-Caps" font. Hover states should trigger an outer glow effect. Secondary buttons use a transparent background with a 1px white border at 20% opacity.
- **Cards:** Large, glassmorphic containers. Use a subtle gradient stroke on the top and left edges to define the shape against the dark background. Images inside cards should have a subtle vignette to blend into the container.
- **Input Fields:** Dark, recessed backgrounds with a bottom-only 2px border that illuminates in the Primary color when focused.
- **Chips/Tags:** Small, sharp-edged boxes with a low-opacity fill of the primary color and high-contrast text.
- **Progress Bars:** Thin, high-intensity glowing lines. Use "Fiery Red" for filled states and "Deep Charcoal" for empty states.
- **Media Player:** Custom immersive controls featuring translucent glass panels and "Space Grotesk" labels for timestamps.