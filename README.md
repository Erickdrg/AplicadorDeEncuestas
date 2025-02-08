# AplicadorDeEncuestas
Aplicador de encuestas (Proyecto)

Para el tercer paricial de la materia Programación Web se realizó un pequeño proyecto que consiste en un aplicador de encuestas. Para esto se realizó un pequeño login, en este se entra con un usuario y contraseña que se encuentran en una base de datos, cabe resaltar que la contraseña se encuentra encriptada por lo que resulta mucho mejor. Una vez metiendo el usuario y contraseña correctos nos manda al aplicador de encuestas, donde se agregaron dos encuestas con algunas preguntas para comprobar su funcionamiento. Es importante mencionar que las encuestas se hacen desde la base de datos, y las respuestas de las mismas se guardan en dicha base de datos.

Actualmente como proyecto final se le hicieron algunas modificaciones:
- Se modifico el archivo "encuestas.php" para que una vez contestada una encuesta se pueda modificar la respuesta, es decir, en la base de datos no se agregue una nueva respuesta.
- Se le agrego un botón "Crear Nueva Encuesta", al oprimir este boton nos deja agregar una nueva encuesta y se guarda correctamente en la base de datos. Para implementar esto se creó un nuevo archivo llamado "crear_encuesta.php".

Equipo:
- Ramírez González Erick Daniel
- López Camarillo Daniel

  

![image](https://github.com/user-attachments/assets/6215e01d-efcf-44b3-bdba-d2e7b484690c)
En esta imagen se muestra el login. 

<br> </br>
<br> </br>


![image](https://github.com/user-attachments/assets/15682062-659d-4224-9963-2743cf5da2d6)
Una vez dentro, podemos observar las encuestas disponibles y la opción de responder.

<br> </br>
<br> </br>

![image](https://github.com/user-attachments/assets/2973ae67-8636-41ce-ac37-4386d58509df)
Ejemplo de una encuesta que se va a responder.

<br> </br>
<br> </br>


![image](https://github.com/user-attachments/assets/0373ac69-f14f-422f-8028-d4fd01dd2878)
Una vez enviada la respuesta de la encuesta te manda un mensaje y la opción de volver a donde las encuestas.


<br> </br>
<br> </br>

![image](https://github.com/user-attachments/assets/1a9ae57e-82b5-4739-979a-1ebbdb632cb1)
Las respuestas se guardan en la base de datos.

<br> </br>
<br> </br>

# Pruebas de las modificaciones realizadas
<br> </br>

| ![Descripción de la imagen 1](https://github.com/user-attachments/assets/ef89c0d7-d2e7-44c6-98d6-bf78e4bbb8ee) En esta imagen vemos lo que el usuario contestó anteriormente en una encuesta.| ![Descripción de la imagen 2](https://github.com/user-attachments/assets/7af11284-4892-4602-ae2f-316fdad66b50) En esta imagen observamos que están guardadas correctamente en la base de datos (id_pregunta(1-5))|
|----------------------------------------------------------------------------------------------------------------|----------------------------------------------------------------------------------------------------------------|

<br> </br>
<br> </br>


| ![Descripción de la imagen 1](https://github.com/user-attachments/assets/72414f6c-8274-4594-92f2-3e61c8cc1e87) En esta imagen le modificamos las primeras tres respuestas a las preguntas y le damos al botón "Guardar respuestas".| ![Descripción de la imagen 2](https://github.com/user-attachments/assets/4fdf7711-39fb-433f-9d18-9537b119eea2) En esta imagen podemos ver que en efecto se modificaron las respuestas a las preguntas que modificamos (id_pregunta(1-3)) de manera correcta en la base de datos.|
|----------------------------------------------------------------------------------------------------------------|----------------------------------------------------------------------------------------------------------------|

<br> </br>
<br> </br>


![image](https://github.com/user-attachments/assets/e9ff3652-4e93-4b66-b5b1-a01cf3c109ec)
En esta imagen se aprecia el nuevo botón agregado, llamado "Crear Nueva Encuesta".


<br> </br>
<br> </br>


![image](https://github.com/user-attachments/assets/d1e2aab3-8bd9-4f8f-b7ae-5b1b04d37764)
![image](https://github.com/user-attachments/assets/f71bc94b-9f59-41a2-b4a0-e40a1f604043)

Una vez oprimido el botón, nos da la opción de crear nuestra nueva encuesta (Titulo de la encuesta, descripción, preguntas y el tipo de pregunta). Una vez terminado el proceso oprimimos el botón "Guardar encuesta".

<br> </br>
<br> </br>

![image](https://github.com/user-attachments/assets/ccd76ca4-a341-4585-91af-cbb6d19eed0c)
Inmediatamente después podemos observar que ya nos aparece nuestra nueva encuesta que llamamos "Encuesta Academica".

<br> </br>
<br> </br>

![image](https://github.com/user-attachments/assets/95fa4aa0-778c-43e2-8495-9d3cdb2fd713) 
Oprimimos el botón de responder para ver que en efecto son las preguntas que agregamos.

<br> </br>
<br> </br>

| ![Descripción de la imagen 1](https://github.com/user-attachments/assets/16cb9fa6-5393-4ff8-be76-38f47f7f79cd) En esta imagen observamos que la encuesta se guardó correctamente en la base de datos.| ![Descripción de la imagen 2](https://github.com/user-attachments/assets/36837f3d-eb4b-494a-9ae1-bb9f0c8cbd1e) Podemos ver que también las preguntas se guardaron correctamente.|
|----------------------------------------------------------------------------------------------------------------|----------------------------------------------------------------------------------------------------------------|




























