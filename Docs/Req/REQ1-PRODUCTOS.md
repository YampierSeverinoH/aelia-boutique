1. Primera parte: módulo de productos

La primera versión debería cubrir:

Categorías
Productos
Variaciones
Atributos
Valores de atributos
Colores
Imágenes
Videos
Precios
Ofertas/descuentos
Estado/publicación
Productos destacados
Nuevos lanzamientos
Ordenamiento del catálogo

Todo debe manejarse mediante:

Producto → Categoría → Atributos → Variantes

Así Aelia podrá agregar posteriormente cualquier tipo de prenda sin modificar la estructura.

2. Estructura general

La relación principal sería:

categories
    │
    └──── products
              │
              ├──── product_variants
              │          │
              │          ├──── variant_attributes
              │          │
              │          └──── variant_images
              │
              ├──── product_images
              ├──── product_videos
              ├──── product_prices
              └──── product_reviews

Y para las características:

attributes
    │
    └──── attribute_values
              │
              └──── product_variant_attributes

Ejemplo:

Producto:
"Blusa Elegance"

Categoría:
Blusas

Atributos:
- Color
- Talla

Valores:
Color:
- Rosado
- Negro
- Blanco

Talla:
- S
- M
- L

Entonces las variantes serían:

Blusa Elegance
├── Rosado / S
├── Rosado / M
├── Rosado / L
├── Negro / S
├── Negro / M
├── Negro / L
...

Esto es mucho más flexible que poner color, talla, etc. directamente en products.

3. Tablas principales

Yo empezaría con estas tablas.

Tabla	Propósito
categories	Categorías y subcategorías
products	Información general del producto
product_variants	Variaciones vendibles
attributes	Atributos como talla, color, material
attribute_values	Valores de cada atributo
product_variant_attributes	Relación variante ↔ atributo
colors	Colores visuales de la tienda
product_images	Galería de productos
product_variant_images	Imágenes específicas de una variante
product_videos	Videos del producto
product_prices	Historial/tipos de precios
product_offers	Ofertas y descuentos

Posteriormente:

customers
addresses
carts
cart_items
orders
order_items
payments
shipments
reviews
wishlists
coupons
social_links
pages
complaints_book
settings

Pero no las metería todavía.

4. categories

Debe permitir:

Ropa
├── Polos
├── Camisas
├── Blusas
├── Pantalones
├── Vestidos
└── Casacas
Campos
id
parent_id
name
slug
description
image
is_active
sort_order
created_at
updated_at
parent_id

Es importante porque permite categorías jerárquicas.

Por ejemplo:

Ropa
   └── Blusas
5. products

Esta será la tabla principal.

Campos recomendados
id
category_id
name
slug
sku
short_description
description
base_price
sale_price
cost
stock
has_variants
is_active
is_featured
is_new
is_on_sale
published_at
meta_title
meta_description
created_at
updated_at

Pero haría una pequeña modificación importante:

No dependería exclusivamente de category_id

Un producto puede pertenecer a varias categorías.

Por ejemplo:

Vestido Aurora

Categorías:
- Vestidos
- Nuevos
- Ofertas
- Más vendidos

Por eso recomiendo:

categories
products

category_product

La relación sería:

products
    ↕
category_product
    ↕
categories

Entonces products no necesita necesariamente category_id.

6. attributes

Aquí manejamos:

Talla
Color
Material
Marca
Estilo

Campos:

id
name
slug
type
is_active
sort_order
created_at
updated_at

type podría ser:

text
select
color

Por ejemplo:

Talla → select
Color → color
Material → select
7. attribute_values

Aquí almacenamos los valores.

Ejemplo:

attribute
    Talla

values:
    XS
    S
    M
    L
    XL

Campos:

id
attribute_id
name
slug
value
sort_order
is_active
created_at
updated_at
8. Colores

Como el cliente específicamente quiere mostrar colores visualmente, yo sí tendría una tabla colors.

colors

Campos:

id
name
slug
hex_code
image
is_active
created_at
updated_at

Ejemplo:

Rosado
#E8A4B8

Dorado
#D4AF37

Negro
#000000

Esto permitirá que en Blade puedas mostrar:

○ Rosado
○ Negro
○ Blanco

y no solamente el nombre.

9. product_variants

Esta es una de las tablas más importantes del proyecto.

No deberíamos asumir que el producto solamente tiene una variante.

Ejemplo:

Producto:
Polo Oversize Aelia

SKU:
PO-001

Variantes:

PO-001-RS-S
PO-001-RS-M
PO-001-RS-L

PO-001-NE-S
PO-001-NE-M
PO-001-NE-L

Campos:

id
product_id
sku
name
price
sale_price
cost
stock
weight
is_active
created_at
updated_at

Aquí tienes una decisión importante:

Precio por variante

El cliente explícitamente dijo:

"si puede cambiar el tema de precio en el tema de productos por colores y variaciones"

Por eso sí debemos permitir precio por variante.

Ejemplo:

Polo
Precio base: S/ 59.90

Rosado / M
S/ 59.90

Negro / M
S/ 64.90

Edición especial / M
S/ 69.90
10. product_variant_attributes

Esta tabla conecta:

Variante
    ↓
Color
Talla

Ejemplo:

variant_id = 10

Color = Rosado
Talla = M

Estructura:

id
product_variant_id
attribute_id
attribute_value_id
created_at
updated_at

Así la variante queda:

Polo Oversize
    └── Variante #10
          ├── Color → Rosado
          └── Talla → M
11. Imágenes

Yo separaría las imágenes generales de las imágenes de las variantes.

product_images

Para imágenes generales:

id
product_id
path
alt
sort_order
is_primary
created_at
updated_at

Ejemplo:

Polo Oversize

01-front.jpg
02-back.jpg
03-model.jpg
04-detail.jpg
12. product_variant_images

Esta tabla es muy importante para el requerimiento:

"al momento que pasas el mouse por la imagen del producto, pueda cambiar la foto"

Ejemplo:

Producto:
Vestido Aurora

Variante:
Rosado

Imágenes:
rosado-01.jpg
rosado-02.jpg
rosado-03.jpg

Y:

Variante:
Negro

Imágenes:
negro-01.jpg
negro-02.jpg
negro-03.jpg

Así el frontend puede cambiar automáticamente la galería cuando selecciona el color.

13. Videos

El cliente pidió:

"que se puede incluir el tema de videos"

No guardaría el video directamente en PostgreSQL.

Guardaría referencias.

product_videos

Campos:

id
product_id
title
type
url
thumbnail
sort_order
is_active
created_at
updated_at

type:

youtube
vimeo
upload

Inicialmente incluso podríamos limitarlo a:

youtube

y posteriormente agregar almacenamiento propio.

14. Precios

Pero pensando en un e-commerce real, prefiero:

product_prices

con:

id
product_id
product_variant_id
price
sale_price
starts_at
ends_at
is_active
created_at
updated_at

Esto permite:

Precio normal:
S/ 100

Oferta:
S/ 79.90

Desde:
01/08/2026

Hasta:
15/08/2026

Sin tener que modificar permanentemente el precio original.


15. Requerimientos funcionales del módulo Productos
RF-PRO-001 — Registrar producto

El administrador podrá registrar:

Nombre
SKU
Categoría
Descripción corta
Descripción completa
Precio
Precio de oferta
Imágenes
Videos
Estado
Producto destacado
Nuevo lanzamiento
Producto en oferta
RF-PRO-002 — Categorizar productos

El administrador podrá asignar uno o varios productos a:

Categorías
Subcategorías

Ejemplo:

Ropa
├── Mujer
│   ├── Blusas
│   ├── Pantalones
│   └── Vestidos
RF-PRO-003 — Manejar atributos

El administrador podrá crear atributos:

Talla
Color
Material
Estilo

y sus respectivos valores.

RF-PRO-004 — Manejar variantes

El administrador podrá generar variantes combinando atributos.

Ejemplo:

Color: Rosado
Talla: M

Color: Rosado
Talla: L

Color: Negro
Talla: M

Cada variante podrá tener:

SKU
Precio
Precio de oferta
Stock
Imágenes
Estado
RF-PRO-005 — Manejar colores

El sistema permitirá seleccionar colores visualmente mediante:

Nombre
Código hexadecimal
Imagen opcional
RF-PRO-006 — Galería de imágenes

Cada producto podrá tener múltiples imágenes.

El administrador podrá definir:

Imagen principal
Orden
Texto alternativo
Imágenes secundarias
RF-PRO-007 — Imágenes por variante

Cada variante podrá tener su propia galería.

Esto permitirá que al seleccionar:

Rosado

el frontend muestre las imágenes correspondientes al color rosado.

RF-PRO-008 — Videos

El administrador podrá asociar videos al producto.

El frontend podrá mostrar:

Galería
Fotos
Video
RF-PRO-009 — Precios

El sistema permitirá:

Precio regular
Precio promocional
Precio por variante
Fecha de inicio de oferta
Fecha de fin de oferta
RF-PRO-010 — Productos destacados

El administrador podrá marcar:

⭐ Destacado

Estos productos podrán aparecer en:

Inicio
Productos destacados
RF-PRO-011 — Nuevos lanzamientos

El administrador podrá marcar:

🆕 Nuevo

para mostrarlo en la sección:

Nuevos lanzamientos
RF-PRO-012 — Ofertas

El administrador podrá marcar productos como:

🔥 Oferta

y mostrar:

S/ 149.90
S/ 99.90
-33%
17. Cómo lo llevaría a Filament

En Filament no haría un único formulario gigantesco.

Crearía:

ProductResource

con secciones.

Información general
Nombre
SKU
Categorías
Descripción corta
Descripción
Comercial
Precio
Precio oferta
Costo
Clasificación
Destacado
Nuevo
Oferta
Activo
Imágenes
Galería
Videos
Videos
Variantes
¿Tiene variantes?

Si:

Sí

mostrar:

Variantes
18. Resources que crearía

Para esta primera fase:

CategoryResource
ProductResource
AttributeResource
ColorResource

Y posiblemente:

ProductVariantRelationManager
ProductImageRelationManager
ProductVideoRelationManager

No necesariamente crearía un ProductVariantResource independiente inicialmente.

Es mejor administrarlo desde:

ProductResource
    └── Variantes

porque conceptualmente las variantes pertenecen al producto.

19. Orden de migraciones

Yo las haría en este orden:

01_create_categories_table
02_create_attributes_table
03_create_attribute_values_table
04_create_colors_table
05_create_products_table
06_create_category_product_table
07_create_product_variants_table
08_create_product_variant_attributes_table
09_create_product_images_table
10_create_product_variant_images_table
11_create_product_videos_table
12_create_product_prices_table

De esta manera las FK siempre tendrán sus tablas previamente creadas.

20. Estructura Laravel

Quedaría aproximadamente:

app/
├── Filament/
│   └── Resources/
│       ├── CategoryResource/
│       ├── ProductResource/
│       ├── AttributeResource/
│       └── ColorResource/
│
├── Models/
│   ├── Category.php
│   ├── Product.php
│   ├── ProductVariant.php
│   ├── Attribute.php
│   ├── AttributeValue.php
│   ├── Color.php
│   ├── ProductImage.php
│   ├── ProductVariantImage.php
│   ├── ProductVideo.php
│   └── ProductPrice.php
21. Algo importante para tu frontend Blade

Desde ahora debemos diseñar el modelo pensando en que el frontend necesitará algo así:

$product->name
$product->slug
$product->description
$product->categories
$product->images
$product->videos
$product->variants
$product->attributes

Y poder obtener:

$product->variants
    ->first()
    ->attributes

para construir dinámicamente:

Talla
○ S
○ M
○ L

Color
○ Rosado
○ Negro
○ Blanco

Luego, cuando el usuario selecciona:

Rosado + M

Blade/JavaScript podrá identificar:

variant_id = 25

y obtener:

SKU
precio
precio oferta
stock
imágenes

Esto será fundamental para el carrito, porque el carrito no debería agregar solamente:

product_id = 10

sino:

product_id = 10
variant_id = 25
quantity = 2
22. Qué NO haría todavía

Para evitar sobrecomplicar esta primera parte, dejaría fuera temporalmente:

Carrito
Pedidos
Clientes
Pagos
Cupones
Reseñas
Libro de reclamaciones
Redes sociales
WhatsApp
Métricas
Términos y condiciones
Seguimiento de pedidos

No porque no sean importantes, sino porque dependen de una base de productos bien construida.

El orden que te recomiendo para todo el proyecto sería:

FASE 1
PRODUCTOS
│
├── Categorías
├── Productos
├── Atributos
├── Variantes
├── Colores
├── Imágenes
├── Videos
└── Precios/ofertas

        ↓

FASE 2
CATÁLOGO FRONTEND
│
├── Inicio
├── Categorías
├── Listado
├── Filtros
├── Producto
├── Galería
└── Variantes

        ↓

FASE 3
CARRITO
│
├── Agregar
├── Modificar
├── Eliminar
├── Variantes
└── Totales

        ↓

FASE 4
PEDIDOS
│
├── Checkout
├── Cliente
├── Dirección
├── Pedido
├── Detalle
└── Estados

        ↓

FASE 5
E-COMMERCE COMPLEMENTARIO
│
├── Ofertas
├── Cupones
├── Reseñas
├── Wishlist
└── Productos relacionados

        ↓

FASE 6
CONTENIDO Y CONFIGURACIÓN
│
├── Redes sociales
├── WhatsApp
├── Términos
├── Privacidad
├── Libro de reclamaciones
└── Configuración

        ↓

FASE 7
MÉTRICAS
│
├── Google Analytics
├── Pixel
├── Eventos
└── Conversiones

Mi recomendación para continuar

Como quieres hacerlo por partes, yo empezaría ahora directamente con la Parte 1: Productos, pero antes de generar todo el código hay una decisión de arquitectura que considero importante: definir exactamente las migraciones completas + modelos Eloquent + relaciones + ProductResource de Filament + RelationManagers + CategoryResource, AttributeResource y ColorResource.

Después podemos avanzar al frontend Blade del catálogo y hacer que consuma exactamente esta estructura, sin tener que rehacer las tablas cuando lleguemos al carrito y pedidos.