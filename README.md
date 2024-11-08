# Task Master - Dependencies Installation Guide

Welcome to the **Task Master** project! To get started and run the application, you'll need to install the necessary dependencies. Below are the instructions to set up your development environment and install all the required packages.

## Prerequisites

Make sure you have the following installed on your machine:
- **Node.js** (v14 or higher)
- **npm** (Node Package Manager, which comes with Node.js)

If you don't have Node.js and npm installed, you can download and install them from [here](https://nodejs.org/).

## Steps for Installing Dependencies

### 1. Clone the Repository

If you haven't already cloned the repository, run the following command:
```bash
git clone <repository-url>
cd <repository-directory>
```

### 2. Install Dependencies
Run the following command to install all the necessary dependencies:

```bash
npm install
```
 This will install the following packages:

- **bcryptjs**: A library to hash passwords and perform encryption.
- **cookie-parser**: A middleware to parse cookies.
- **cors**: A package to enable Cross-Origin Resource Sharing.
- **dotenv**: A zero-dependency module to load environment variables from a `.env` file.
- **express**: A web framework for Node.js to build RESTful APIs.
- **jsonwebtoken**: A library to sign and verify JSON Web Tokens (JWT) for authentication.
- **mongoose**: An ODM (Object Data Modeling) library for MongoDB and Node.js.
- **nodemon**: A tool that automatically restarts your Node.js server during development when file changes are detected.

### 3. Start the Application
You can run the server in two different ways:

For Production
Run the app using node:

```bash
npm start
```
This will run the app in production mode.

For Development (with auto-restart on file changes)
Run the app using nodemon:

```bash
npm run server
```
This will start the server in development mode, and any file changes will automatically restart the application.



