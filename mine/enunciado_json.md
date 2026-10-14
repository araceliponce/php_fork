Enunciado https://centros.edu.xunta.gal/iespazomerce/aulavirtual/mod/assign/view.php?id=95299

Crea un formulario con un campo textarea que recibe un json con el formato del json de ejemplo y que para cada asignatura almacene dentro de una matriz la nota media, número de suspenso, número de aprobados, nota más alta y quien la saca, nota mínima y quien la saca. El resultado debe seguir el formato del array $_resultado. Muestra el resultado en formato tabla.

Además, debe mostrar los siguientes listados:

    Alumnos que han aprobado todo. (div verde)
    Alumnos que han suspendido al menos una asignatura. (div amarillo)
    Alumnos que promocionan (alumnos que han suspendido como máximo una asignatura). (div azul)
    Alumnos que no promocionan (alumnos que han suspendido 2 o más asignaturas). (div rojo)

Puedes usar un JSONViewer para ver los datos de forma más fácil.
 
Requisitos mínimos

    Comprobar la entrada del usuario comprobando que:
        El usuario ha insertado un texto.
        El texto es un json válido
        El json sigue el formato establecido en la práctica
    Si hay errores se muestran en la vista debajo el campo erróneo
    Al enviar el formulario haya o no haya errores siempre se muestra la entrada del usuario. Sanea el texto que pondrás en el medio del textarea.
    Solución del ejercicio:
        El número de módulos que nos suministre el usuario puede variar.
        El número de alumnos por módulo puede variar.
        El número de notas por alumno en módulo puede variar.
    Vista
        Si hay un resultado válido haz que se muestren dos divs por fila en pantallas grandes y uno por fila en pantallas inferiores (col-12 col-lg-6). Para los divs usa clases alert alert-$tipo
        Se priorizará el uso de clases estándar de Bootstrap sobre las clases customizadas para el diseño de la interfaz.
        La tabla que realicemos será análoga a la de iterativas08 usando clases de BS con un div que la encierre de tamaño col-12:

Módulo 	Media 	Aprobados 	Suspensos 	Máximo 	Mínimo
Matemáticas 	5,27 	7 	3 	Manuel Muy Listo: 9,53 	Roberto Suspenso Pérez: 2,17
Física 	5,24 	6 	4 	Manuel Muy Listo: 9,13 	Teodoro Va Mal: 1,33
Química 	5,79 	8 	2 	Manuel Muy Listo: 9,13 	Teodoro Va Mal: 2,10
Lengua 	5,99 	8 	2 	Manuel Muy Listo: 8,80 	Roberto Suspenso Pérez: 1,85
Galego 	5,89 	8 	2 	Manuel Muy Listo: 9,03 	Roberto Suspenso Pérez: 2,18