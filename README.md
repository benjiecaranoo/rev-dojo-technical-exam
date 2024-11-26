## Objective: Develop a backend feature in Laravel that allows users to comment on posts, videos, and pictures using a polymorphic relationship.

## Requirements:
# Database Structure:
Implement a comments table that uses a polymorphic relationship to associate comments with posts, videos, and pictures.
Include a users table to track which user made the comment.
# Model Relationships:
Define the appropriate Eloquent relationships in the models (User, Comment, Post, Video, Picture).
# Endpoints:
Create the following RESTful API endpoints:
POST /comments: Add a comment to a post, video, or picture.
GET /comments/{type}/{id}: Retrieve all comments for a specific post, video, or picture.
DELETE /comments/{id}: Delete a specific comment.
# Validation:
Ensure only authenticated users can add or delete comments.
Validate that comments cannot be empty.
# Testing:
Write feature tests to validate the functionality of the endpoints.
Codebase Submission:
Upload the Laravel project codebase to a public Git repository.
Submit the repository link on or before Nov. 26, 2024, 11:59 PM.



## Exam Tasks:
# Database Migration:
Create migrations for users, posts, videos, pictures, and comments.
# Model Configuration:
Configure the models and relationships:
User has many comments.
Comment belongs to commentable (polymorphic).
Post, Video, and Picture have many comments.
API Controller:
Create a CommentController to handle the API endpoints.
# Routes:
Define API routes in api.php.
# Authentication:
Implement Laravel's built-in authentication to secure the endpoints.
# Feature Testing:
Use Laravel's testing tools to ensure:
Comments can be added to any type of entity.
Only authenticated users can interact with comments.
Validation errors are returned for invalid requests.



## Deliverables:
Codebase: Submit the Laravel project code in a public Git repository.
Database Schema: Include an SQL dump of your database structure.
Postman Collection: Provide a collection of API requests for testing.
Test Coverage Report: Share the output of the PHPUnit tests.
Submission Deadline: Share the Git repository link on or before Nov. 26, 2024, 11:59 PM.