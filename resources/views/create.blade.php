<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create User</title>
</head>
<body>

    <h1>Create User</h1>

    <!-- Form for sending POST request -->
    <form action="{{ route('createUser') }}" method="POST">
        @csrf <!-- CSRF Token -->
        
        <div>
            <label for="name">Name</label>
            <input type="text" id="name" name="name" value="Johnrave" required>
        </div>
        
        <div>
            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="johnrave@gmail.com" required>
        </div>
        
        <div>
            <label for="password">Password</label>
            <input type="password" id="password" name="password" value="coopal" required>
        </div>

        <div>
            <button type="submit">Submit</button>
        </div>
    </form>

</body>
</html>