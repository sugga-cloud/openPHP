OpenPHP Installation Guide
Introduction
OpenPHP is a powerful PHP framework that simplifies web development. This guide will help you download and install OpenPHP, as well as integrate it into your project.

Prerequisites
Before you start, ensure you have the following installed on your system (optional but recommended):

PHP (version 7.4 or higher)
External Web Server (such as Apache or Nginx; not required but recommended)
Database (optional, based on your project requirements)
Installation Steps
Step 1: Download OpenPHP
Visit the OpenPHP GitHub Repository: Go to the OpenPHP GitHub page.

Clone the Repository: Open your terminal and navigate to the directory where you want to install OpenPHP. Run the following command:

bash
Copy code
git clone https://github.com/sugga-cloud/openPHP.git
Alternatively, you can download the ZIP file by clicking on the "Code" button and selecting "Download ZIP." Extract the contents to your desired directory.

Navigate to the OpenPHP Directory: Change into the OpenPHP directory:


cd openPHP


Step 3: Configure OpenPHP
Environment Configuration:
Copy the .env.example file to create your environment configuration:


cp .env.example .env
Open the .env file in a text editor and configure your database settings and any other necessary environment variables.

Step 4: Access OpenPHP
Open in Browser: Navigate to the public directory of your OpenPHP installation and open index.php in your web browser. For example, if you’re using a local setup, you can navigate to:

(if using xampp):
http://localhost/openPHP
in build server:
type command 
php open.php start

(php must be installed and added to path)

**Necessary commands**
1. php open.php start for starting server
2. php open.php create:view view_name for creating view (do not include extension)
3. php open.php create:controller controller_name for creating controller (do not include extention)
4. php open.php migrate to initialize sqlite data base

models

use models to create sqlite database, tables.

Introduction
The SQLite class provides a simple interface for interacting with SQLite databases in PHP. It supports basic CRUD operations (Create, Read, Update, Delete), as well as database and table management functionalities.

Namespace
php
Copy code
namespace framework\DataBase;
Requirements
PHP version 7.4 or higher
PDO extension for database interaction
Usage
1. Creating an Instance
To create a new instance of the SQLite class, provide the name of the database (without the .sqlite extension):

php
Copy code
use framework\DataBase\SQLite;

$db = new SQLite('my_database');
If you pass null as the database name, an error message will be displayed.

2. Connecting to the Database
The class automatically connects to the specified database upon instantiation. If the database file does not exist, it can be created.

3. Database Operations
Creating a Table
To create a new table, use the createTable method:

php
Copy code
$columns = [
    'id INTEGER PRIMARY KEY AUTOINCREMENT',
    'name TEXT NOT NULL',
    'email TEXT NOT NULL'
];

$db->createTable('users', $columns);
Inserting Data
To insert data into a table, use the insert method:

php
Copy code
$data = [
    'name' => 'John Doe',
    'email' => 'john@example.com'
];

$id = $db->table('users')->insert($data);
Retrieving Data
To retrieve data, you can use the get method:

php
Copy code
$users = $db->table('users')->get();
For finding a specific record by ID, use the find method:

php
Copy code
$user = $db->table('users')->find(1);
Updating Data
To update existing records, use the update method:

php
Copy code
$data = [
    'email' => 'john.doe@example.com'
];

$db->table('users')->where('id', '=', 1)->update($data);
Deleting Data
To delete records, use the delete method:

php
Copy code
$db->table('users')->where('id', '=', 1)->delete();
4. Query Building
You can build queries using the where method for filtering results:

php
Copy code
$filteredUsers = $db->table('users')->where('email', 'LIKE', '%@example.com')->get();
5. Resetting the Query
To reset the query parameters, use the reset method:

php
Copy code
$db->reset();
6. Database Management
Creating a Database
You can create a new database by providing its name during instantiation. If a database with the same name exists, it will not be created.

Dropping a Database
To drop the current database, use the dropDatabase method:

php
Copy code
$db->dropDatabase();
Dropping a Table
To drop a table, use the dropTable method:

php
Copy code
$db->dropTable('users');
7. Altering a Table
To alter an existing table, use the alterTable method:

php
Copy code
$db->alterTable('users', 'ADD COLUMN age INTEGER');
Error Handling
The class uses exceptions to handle errors related to database operations. Make sure to wrap your database interactions in try-catch blocks to handle any potential exceptions gracefully.

php
Copy code
try {
    $db->createTable('users', $columns);
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage();
}

Features are same for sql database.

open template engine facilities
Replacement Syntax
Asset Syntax:

@asset("path/to/asset")
Variable Output:

{{ variable }}
Conditional Statements:

@if (condition)
Else Statement:

@else
End If Statement:

@endif
Foreach Loop:

@foreach (items)
End Foreach Statement:

@endforeach
Include Syntax:

@include("path/to/partial")
Layout Syntax:

@layout("layout-name")


Conclusion
You have successfully installed OpenPHP and set it up for your project. You can now begin developing your application using the features provided by OpenPHP
