Install Docker Desktop

if you are on windows you should set up wsl2

Pull the project down via github or github desktop

navigate to the project and run this command 
	(build the Docker Desktop containers)
	./vendor/bin/sail up
Please wait for this command to finish setting up our containers

Once the containers are running open a new terminal from Docker Desktop by navigating to Containers / Apps in the left side menu

click on the drop down arrow for your local instance, It should be green and say "RUNNING" underneath.
This will show you which containers we have running for our Laravel 9 application.

Find the container that end's with _laravel.test 
mine looks like ---> take-home_laravel.test_1

If you hover over this container you will see 5 buttons appear on the right side. 
click the one labled CLI and a new terminal for your laravel instance will open.

Now that we have a terminal open we can begin setting up the local instance.

In the terminal we opened via Docker Desktop run these 3 commands
	(install npm dependancies)
	npm install
	(compile stuff for our views)
	npm run dev
	(create our local database) creates Roles, Skills, Applicants, Apllicant Skills, and an Admin User
	php artisan migrate --seed

Emial for Admin: admin@admin.com 
Password for Admin: password

applicants end point -> http://127.0.0.1/api/applicants
