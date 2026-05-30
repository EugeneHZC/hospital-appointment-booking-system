<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../../styles/styles.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://kit.fontawesome.com/d29bed84f6.js" crossorigin="anonymous"></script>
    <script src="../../scripts/load-page.js"></script>
    <script src="../../scripts/add-time-slot.js"></script>
    <title>Hospital Islam Azzahrah Appointment Booking System</title>

    <!-- for testing purposes only -->
    <input type="hidden" value="doctor" name="role" id="role" />
</head>

<body>
    <div id="container">
        <?php include("../../components/doctor/side-nav.html") ?>
        <main>
            <header>
                <h1>Add Time Slot</h1>
                <p id="role-view"></p>
            </header>

            <div id="content">
                <form>
                    <div class="display-cards">
                        <div class="display-card-top-bottom card">
                            <div class="display-card-bottom">

                                <div class="form-group">
                                    <label for="time-slot">Time Slot</label>
                                    <input type="time" name="time-slot" id="time-slot" class="form-control">
                                </div>

                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select type="text" name="status" id="status" class="form-control">
                                        <option value="active">Active</option>
                                        <option value="inactive">Inactive</option>
                                    </select>
                                </div>

                                <div class="btns">
                                    <button class="btn btn-info" type="submit" id="save-btn">
                                        Save
                                    </button>
                                    <button class="btn btn-secondary" id="cancel-btn" type="button">
                                        Cancel
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </main>
    </div>
</body>

</html>