# Design Style Guide

## How to use this guide

Always look into this guide first when you are trying to design a new component.
Try to reuse as much as possible of already existing components.
If there is a component but is slightly different then you need, consider to use a BEM modifier and make only a new variant of it.
Also you can make your new component the general component and convert the existing code into a variant.

## How should my development process look like

Open this style guide and start designing your new component here first and try to think about all the cases and variants.
It's only a HTML page so the development will be way faster when you don't have to deal with JS issues and so on.
Once you prototype it you can easily test it on different screens and devices.
Make sure you provide enough documentation for others and try to think twice about proper naming.

## Naming Conventions - BEM

The **Block, Element, Modifier** methodology is a popular naming convention for classes in HTML and CSS.
Do not use `camelCase` in class names, it's against the BEM spec.

```css
.block {
	&--modifier {
	}

	&__element {
		&--element-modifier {
		}
	}
}
```

## Units

If possible use REMs everywhere.
Try to avoid using pixels at all, it does not scale properly on higher pixel ratios.
Also don't use zero at the beginning of floating numbers.
It's unnecessary long and against SASS standard.

```css
font-size: 0.7rem; // OK

```

## Colors

Always check this [doc](base.html#01-colours) for already existing color variables.
If there is specific color or anything close, reuse it, please.
Other then that, introduce a new variable and try to think twice about correct name for the color.
Also don't forget to create a documentation for the new color.
We don't want to end up with gazilion of colors without even knowing of them.
Consider also using SASS function `darken`, `lighten` and others to derive the colors if they are logically dependent.

## Cascading

Try to avoid cascading as much as possible.
It generates a lot of unnecessary code into the final CSS.
Usually there is no need to have more then 3 levels.

## Pictures

Always cover at least pixel ratio 2x.
Use proper SASS variables and think **mobile first**.
For higher resolutions specify wider pictures to not force mobile devices to always download the large picture.
Check the example below:

```
<picture>
    <source srcset="/images/example-thumbnail-1.avif" type="image/avif" media="(min-width: 992px)" />
    <source srcset="/images/example-thumbnail-1.avif" type="image/avif" media="(min-width: 768px)" />
    <source srcset="/images/example-thumbnail-1.avif" type="image/avif" media="(max-width: 767px)" />
    <source srcset="/images/example-thumbnail-1.avif" type="image/avif" media="(max-width: 520px)" />
    <source srcset="/images/example-thumbnail-1.webp" type="image/webp" media="(min-width: 992px)" />
    <source srcset="/images/example-thumbnail-1.webp" type="image/webp" media="(min-width: 768px)" />
    <source srcset="/images/example-thumbnail-1.webp" type="image/webp" media="(max-width: 767px)" />
    <source srcset="/images/example-thumbnail-1.webp" type="image/webp" media="(max-width: 520px)" />
    <img class="example-image" alt="Example image" src="/images/example-thumbnail-1.webp" width="756" height="390" loading="lazy" />
</picture>
```

## Framework

We do not use Bootstrap framework, we create own design and layout to get best speed performance.
