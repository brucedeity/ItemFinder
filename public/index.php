<!DOCTYPE html>
<html>
    <head>
        <title>ItemFinder Results</title>
        <link rel="icon" type="image/x-icon" href="favicon.ico" />
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <style>
            table {
                border-collapse: collapse;
                width: 100%;
            }

            th,
            td {
                text-align: center;
                padding: 8px;
                border: 1px solid #ddd;
            }

            td.item {
                vertical-align: middle;
            }

            tr:nth-child(even) {
                background-color: #f2f2f2;
            }

            h2 {
                margin-top: 0;
            }

            .error-msg {
                color: red;
            }

            .spinner {
                margin: 20px auto;
                width: 40px;
                height: 40px;
                position: relative;
                border: 4px solid #ddd;
                border-top-color: #777;
                border-radius: 50%;
                animation: spin 1s ease-in-out infinite;
            }

            @keyframes spin {
                to {
                    transform: rotate(360deg);
                }
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="py-5 text-center">
                <h2>PW Item Finder</h2>
                <p class="lead">Search an item through all roles, please note that this can take a while to process!</p>
            </div>
            <h2 class="text-center"></h2>
            <div class="row">
                <div class="col-md-6 offset-md-3">
                    <form id="search-form">
                        <div class="form-group">
                            <label for="itemId">Enter an item ID:</label>
                            <input type="text" id="itemId" name="itemId" class="form-control" />
                        </div>
                        <div>
                            <button id="searchBtn" class="btn btn-primary">Search</button>
                        </div>
                        <div class="spinner" style="display: none;"></div>
                    </form>
                </div>
            </div>
            <br />
            <div class="row">
                <div class="col-md-8 offset-md-2">
                    <div id="elapsed-time" style="display: none; margin-top: 10px; color: grey;">Elapsed time: <span id="time"></span></div>
                    <div id="search-results"></div>
                    <div id="error-msg" class="error-msg"></div>
                </div>
            </div>
        </div>

        <script>
            $(document).ready(function () {
                $("#search-form").submit(function (event) {
                    $("#search-results").html("");

                    event.preventDefault();
                    var itemId = $("#itemId").val();

                    if (itemId === "") {
                        $(".error-msg").text("Please enter an item ID.");
                    } else {
                        $(".error-msg").text("");
                        var startTime = new Date();
                        var intervalId = setInterval(function () {
                            var elapsedTime = Math.round((new Date() - startTime) / 1000);
                            $("#elapsed-time")
                                .show()
                                .text("Elapsed time: " + elapsedTime + " seconds");
                        }, 1000);
                        $(".spinner").show();
                        $("#searchBtn").prop("disabled", true);
                        $.get("search.php", { itemId: itemId }, function (response) {
                            clearInterval(intervalId);
                            $(".spinner").hide();
                            $("#search-results").html(response);
                            var endTime = new Date();
                            var elapsedTime = Math.round((endTime - startTime) / 1000);
                            $("#elapsed-time")
                                .show()
                                .text("Elapsed time: " + elapsedTime + " seconds");

                            $("#searchBtn").prop("disabled", false);
                        });
                    }
                });
            });
        </script>
    </body>
</html>
