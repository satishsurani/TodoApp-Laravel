# Todo App

This is a simple Todo application that allows users to create, read, update, and delete tasks. The app provides a clean user interface with Bootstrap and offers basic CRUD (Create, Read, Update, Delete) functionality.

## Features

- **Add Todo**: Allows users to create new tasks by providing a subject and description.
- **Update Todo**: Users can update the subject or description of an existing task.
- **Delete Todo**: Users can remove a task from the list.
- **Search Todo**: A search bar to filter tasks based on the subject or description.
- **Responsive Design**: The app is responsive and works well on both desktop and mobile devices.

## Tech Stack

- **Backend**: Laravel (PHP framework)
- **Frontend**: HTML, CSS, JQuery, Bootstrap
- **Database**: MySQL

## Installation

### Prerequisites

- PHP >= 7.4
- Composer
- MySQL
- Node.js (for frontend dependencies)

A simple Todo application built with Laravel for backend and basic frontend assets.


### Steps

1. **Clone the repository to your local machine:**

   ```sh
    git clone https://github.com/satishsurani/TodoApp-Laravel
    cd TodoApp-Laravel
2. **Install PHP dependencies using Composer:**
   ```sh 
    composer install
3. **Create a .env file by copying the example configuration:**

   ```sh
   cp .env.example .env
4. **Generate the application key:**

   ```sh
   php artisan key:generate
5. **Set up your MySQL database and update the .env file with your database credentials:**
   ```sh
     DB_CONNECTION=mysql
     DB_HOST=127.0.0.1
     DB_PORT=3306
     DB_DATABASE=todoApp
     DB_USERNAME=root
     DB_PASSWORD=your_password
6. **Run the database migrations:**

   ```sh
    php artisan migrate
7. **Install Node.js dependencies (if you want to work with frontend assets):**
   ```sh
    npm install
8. **Compile the frontend assets:**

   ```sh
    npm run dev
9. **Start the development server:**

   ```sh
   php artisan serve

The app will be accessible at `http://127.0.0.1:8000`.

## Usage

- **Add a Todo**: Click the "Add Todo" button to open the modal form. Enter a subject and description for your task, then click "Add Todo" to save it.
- **Update a Todo**: Click the "Update Todo" button next to an existing task to edit the subject or description.
- **Delete a Todo**: Click the "Delete Todo" button to remove a task from the list.
- **Search Todos**: Use the search bar to filter tasks based on subject or description.

## File Structure

- **app/**: Contains the backend logic for the Todo app (Controllers, Models).
- **resources/views/**: Contains the HTML templates for the Todo app (views).
- **public/**: Contains the assets such as images, stylesheets, and JavaScript files.
- **routes/web.php**: Defines the routes for the app (CRUD operations).
- **database/migrations/**: Contains the database migrations for the Todo app schema.
## Routes

Here are the available routes in the Todo application:

- **GET /**: Displays the main page with the list of Todos.
  - Route Name: `index`
  - Controller Method: `TodoController@index`

- **POST /insert**: Allows you to add a new Todo item.
  - Route Name: `insert`
  - Controller Method: `TodoController@store`

- **POST /update/{id}**: Allows you to update an existing Todo item by its ID.
  - Route Name: `update`
  - Controller Method: `TodoController@update`

- **DELETE /delete/{id}**: Deletes a Todo item by its ID.
  - Route Name: `delete`
  - Controller Method: `TodoController@destroy`

- **GET /search**: Provides search functionality to filter Todos based on subject or description.
  - Route Name: `search`
  - Controller Method: `TodoController@search`

## Contributing

If you'd like to contribute to the project:

1. Fork the repository.
2. Create a new branch (e.g., `git checkout -b feature-name`).
3. Commit your changes (`git commit -am 'Add new feature'`).
4. Push to the branch (`git push origin feature-name`).
5. Create a new pull request.