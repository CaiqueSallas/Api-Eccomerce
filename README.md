# Api-Eccomerce
Eccomerce Api Build in Laravel

<h1>How to execute</h1>

<h3> requirements: </h3>
<ul>
<li> Docker: https://www.docker.com/get-started </li>
<li> Postman (to see the documentation): https://www.postman.com/ </l1>
<li> Git: https://git-scm.com/ </l1>
<li> PgAdmin if you want to see the Database: https://www.pgadmin.org/download/pgadmin-4-windows/ </li>
</ul>

<h3>executing: </h3>
<ol>
<li>Clone the project with "git clone https://github.com/CaiqueSallas/Api-Eccomerce.git"  </li>
<li>Clone the .env file with "copy .env.example .env"</li>
<li>Run Docker with "docker-compose up -d --build"</li>
<li>Open your docker, click on the api container and open the CLI window</li>
<li>Now, execute the follow commands: "composer install" "php artisan migrate" "php artisan db:seed" "php artisan key:generate"
</ol>

<h3> Postman Documentation: </h3>
<h4> to see the postman documentation, click in import on the top left of the postman and past the link below: </h4>
<h4>https://www.getpostman.com/collections/6e542feb94bdc994f18e</h4>
<h4> To make requests you have to take a token on User Login and put on the Token variable by clicking on the eye on the right top of postman (Remember to put a "Bearer" before the token key)</h4>
