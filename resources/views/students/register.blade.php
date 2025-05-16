<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Registration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">Student Registration</h4>
                    </div>
                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if(session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif

                        <form action="{{ route('student.register') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="STUDENT_ID" class="form-label">Student ID (Numbers Only)</label>
                                    <input type="number" class="form-control" id="STUDENT_ID" name="STUDENT_ID" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="EMAIL" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="EMAIL" name="EMAIL" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="LAST_NAME" class="form-label">Last Name</label>
                                    <input type="text" class="form-control" id="LAST_NAME" name="LAST_NAME" required>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="FIRST_NAME" class="form-label">First Name</label>
                                    <input type="text" class="form-control" id="FIRST_NAME" name="FIRST_NAME" required>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="MIDDLE_NAME" class="form-label">Middle Name</label>
                                    <input type="text" class="form-control" id="MIDDLE_NAME" name="MIDDLE_NAME">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="SEX" class="form-label">Sex</label>
                                    <select class="form-select" id="SEX" name="SEX" required>
                                        <option value="">Select Sex</option>
                                        <option value="M">Male</option>
                                        <option value="F">Female</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="CONTACT_NUMBER" class="form-label">Contact Number</label>
                                    <input type="text" class="form-control" id="CONTACT_NUMBER" name="CONTACT_NUMBER" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>

                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">Confirm Password</label>
                                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">Register</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 