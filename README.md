### *** Sistema de extracción registro de asistencia ZKTECO  ***

- Importa o recrea el dump-marcacion_reloj-202201280952.sql en tu BBDD MySQL.
- El codigo es ejecutado desde cdata.php, cuidado dentro de este archivo se invoca de esta forma http://localhost/iclock/cdata.php?ip=$ip, pero si lo ejecutaras en un ambiente local no hay problema, solo debes procurar cambiar a una IP distinta en el caso que lo requieras, pero no deberias. 
- La "variable de entorno" esta en el archivo env.php.example, solo debes de copiarla y dejarla con el nombre env.php, posteriormente colocas los datos de tu conexión a MySQL.
- El archivo "cron.sh" es el encargado de realizar la petición a la API, configura tu cron o programador de tareas para ejecutarlo ejemplo (donde 10.6.17.116 es la IP de tu reloj)
  - Cada un segundo:
    
  ```bash
  */1 * * * * sh /var/www/html/iclock/cron.sh 10.6.17.116
  ```

  - Ejemplo de ejecución  manual:
  ```bash
  http://localhost/iclock/cdata?ip=10.6.17.216
  ```
- Listo ya lo puedes usar
