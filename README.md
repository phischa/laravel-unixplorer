# nextright Homework

This repository contains a basic laravel application to explore universities in Germany. Your task is to implement a few features/views in this application. The tasks are designed for you to present basic Fullstack skills and how you can read up on new concepts. You should be able to complete the tasks in a few hours, way shorter if you are already familiar with Laravel and Vue.js. If you need more time, that's not a problem. Please don't hesitate to contact me if you have any questions.

## Setup

Before you can start, you need to setup the project. Laravel requires PHP 8.2 and [composer](https://getcomposer.org/) as a dependency manager. You can install them locally or use a tool like Laravel Sail if you prefer to use Docker. See [the Laravel Sail documentation](https://laravel.com/docs/12.x/sail) for more information. The default database is SQLite, which should be sufficient for this project. If you have any issues setting up the project, please contact me, as it shouldn't get on the way of completing the tasks.

1. Create a new GitHub repository using this repository as a template. You can make your repository private, if you want to. But if you do, please add me as a collaborator. My GitHub username is `IdrisN`.
2. Clone your new repository to your local machine and change into the project directory.
3. Install the dependencies

    ```bash
    composer install && npm install
    ```

4. Copy the `.env.example` file to `.env` and generate a new application key.

    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

5. Create a file called `database.sqlite` in the `database` directory.

    ```bash
    touch database/database.sqlite
    ```

6. Migrate the database and run the database seeder.

    ```bash
    php artisan migrate --seed
    ```

7. Done 🎉 Now you should be ready to go!

## Tasks

The project contains a fresh laravel application created using the laravel installer. Vue.js and Inertia.js was also added. A `University` and a `Course` model already exist. The database was seeded with a few universities and courses.

Implement the tasks below. You are free to use any package you want but i don't think you will need any. You can also change the existing code if you want to. I would recommend to use Tailwind CSS for styling. The tasks are formulated very broadly. You are free to design the views as you want. Please try to stay close to laravel/PHP and Vue.js best practices and conventions in your code style.

Please commit your changes to your repository as you go. I would like to see your progress. You don't have to commit after every change. But please commit at least after every task.

### Task 1: The "Popularity" Index

The first task is to show a paginated list of all universities. The list should contain the **name** of the university, the **link** to their website, the **number of courses** and the **average rating** of all courses. The list should be sorted by the average rating of the courses in descending order (highest rated universities first).

You are free to design the list as you want. You can use the `university.index` view to display the list.

### Task 2: Search & Filter

The second task is to design and implement filters and a search for the university list. A search input should allow the user to search for a university by name, and a select menu should allow filtering by course. I.e. the list should only contain universities that offer the selected course. The search input and filter can be placed above the list. Additionally, add a checkbox to only show universities with an average rating of 4 or higher.

### Task 3: The Application

Now that we have a list of universities, we want to allow the user to apply for a university. Therefore, we need a detail view for each university with an application form. Create a detail view for each university that can be accessed by clicking on a university in the list. The detail view should show the details of the university and an application form. You can use the `university.show` view for this.

Now we want to simulate the ability to apply for a university. Add a button and two input fields to the detail view of a university. A user should be able to enter their name and email address and apply for the university. In order to simulate an application, you need to do the following:

- Create an application model with the following attributes: `name`, `email`, `university_id`
- Create a relationship between the application and the university model
- Create a route to store a new application

When a user applies for a university, the request should be validated and a new application should be created.

#### Validation Criteria

- The name field is required and must be at least 3 characters long
- The email field is required and must be a valid email address
- A user cannot apply for the same university more than once with the same email address
- A user cannot apply to more than 3 universities in a single day using the same email address

If the validation fails, the user should be redirected back to the detail view with the validation errors. If the application is created successfully, the user should be redirected back to the detail view with a success message.

## Task 4: Accept/Reject Applications

If the application is created successfully, the system should simulate assessing the application by randomly sending a rejection or acceptance email to the user. Since sending mails is slow, this must happen in the background using a job queue. Laravel has a very good documentation on how to handle jobs, queues and emails. You can find it here: <https://laravel.com/docs/12.x/queues> and here: <https://laravel.com/docs/12.x/mail>.

Don't worry, you won't need to setup a real mail server. You can use the `log` mail driver which will simply write the email content to the log file. If you want to inspect the mails more closely, you can use [mailpit](https://mailpit.dev/), which is a local SMTP server with a web interface to view the mails. I've added the mail configuration for mailpit to the `.env.example` file.
For the queue you can just use the `database` connection (check the driver prerequisites in the documentation).

The goal of this task is to see if you can read up on new concepts and implement them correctly. Hence, you are very free to approach this task as you want. The following steps should be done:

- Create a job to handle the application
- Dispatch the job when creating a new application with a delay of 15 seconds
- The job should randomly accept or reject the application
- Send an email to the user with the result of the application
- Model a way to store the result of the application (accepted or rejected)

### Rating Criteria

The tasks are formulated very broadly. You are free to design the views as you want. It is important that the tasks are implemented correctly and that you follow best practices and conventions for Laravel, Vue and Inertia.js. Your design does not have to win awards but it should be modern and easy to use.

## Submission

When you are done, please send me a link to your repository. Please make sure, that I have access to your repository. My GitHub username is `IdrisN`.

If you have any questions, feel free to contact me. I'm happy to help you.

Good luck and have fun!
