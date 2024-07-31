## DECATECH Platform
### Description
This project is a management platform where the structure is presented with its services, and where users can create and publish posts, manage comments, and browse through various blog entries. It features functionalities as registration and authentification and permits admin roles.

### Table of Contents
    - Features
    - Technologies
    - Setup
    - Configuration
    - Overview
        |- Home
        |- Blog
        |- Services
        |- Blog
            |- Post
              |- Add
              |- View
            |- Comment
              |- Add
        |- Authentification
            |- Registration
            |- Login

### Features
- Users: CLASSIC USER and ADMIN Roles, Registration, Login, and Logout.
- Services: View services and Filter posts.
- Posts: Add and View posts.
- Comments: Add and View comments.

### Technologies Used
- JavaScript and CSS
- Templating Engine: Twig
- Framework: Symfony 7
- Database: MySQL

### Setup
##### Prerequisites
- PHP >= 8.2 if you want to use symfony 7
- Composer
- MySQL

##### Steps Clone the repository:

```bash
git clone https://github.com/whitecodename/decatechs-forum.git
cd decatechs-forum
```

##### Install dependencies:

```bash
composer install
```

##### Set up the environment variables:
Copy the .env file and configure your database connection and other settings:

```bash
cp .env .env.local
```

##### Create the database:

```bash
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
```

##### Run the Symfony server:

```bash
symfony server:start
````
Or use:
```bash
php -S localhost:8000 -t public
```

### Configuration

#### Routes Configuration
hese are the routes available on the platform:

- About Page: **AboutController::index**
- Admin Page: **AdminController::index**
- Comment Page: **CommentController::index**
- Create Comment Page: **CommentController::create**
- Forum Page: **ForumController::index**
- Show a service's posts: **ForumController::show**
- Home Page: **HomeController::index**
- Show a post's comments: **PostController::show**
- Registration Page: **RegistrationController::register**
- Login Page: **SecurityController::login**
- Logout Page: **SecurityController::logout**
- Services Page: **ServiceController::index**

#### Environment Configuration
Update the .env.local file with your database credentials, mailer settings, and other environment-specific variables.

```dotenv
DATABASE_URL="mysql://username:password@127.0.0.1:3306/db_name"
APP_ENV=dev
APP_SECRET=your_secret_key
```

### Overview
These are the differents interfaces of the plateform :

#### HomePage
- ![Home1](./public/images/home1.png)
- ![Home2](./public/images/home2.png)
- ![Home3](./public/images/home3.png)
- ![Home4](./public/images/home4.png)
- ![Home5](./public/images/home5.png)

#### Services
- ![Services](./public/images/services.png)

#### Blog
- ![Blog](./public/images/blog.png)

##### Post

###### Add
- ![Add](./public/images/add-post.png)

###### View Post
- ![View](./public/images/view-post.png)

##### Comment

###### Add
- ![Add](./public/images/add-comment.png)

#### Authentification

##### Registration
- ![Registration](./public/images/register.png)

##### Login
- ![Login](./public/images/login.png)
