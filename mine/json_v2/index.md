
Crea una página web que permita introducir un JSON mediante un formulario con un campo textarea. El JSON contendrá las ventas realizadas por varios empleados en diferentes productos.
El programa debe calcular, para cada producto, el importe total vendido, el número de ventas realizadas, el precio medio por venta y el empleado que ha generado más ingresos.
Además, debe mostrar los siguientes listados:
- Mejores vendedores: empleados que han generado más de 500 € en ventas (div verde).
- Vendedores con pocas ventas: empleados que han generado menos de 200 € (div amarillo).
- Vendedores destacados: empleados que han vendido al menos 3 productos diferentes (div azul).
- Vendedores por debajo del objetivo: empleados que han generado menos de 500 € en ventas (div rojo).

{
  "Teclado": {
    "Ana": [50, 60, 45],
    "Luis": [30, 25],
    "Marta": [80, 90, 70]
  },
  "Monitor": {
    "Ana": [200, 180],
    "Luis": [150, 170, 160],
    "Marta": [220]
  },
  "Ratón": {
    "Ana": [20, 25, 15],
    "Luis": [30, 35, 25],
    "Marta": [40, 45]
  }
}