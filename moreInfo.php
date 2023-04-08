<html>

<head>
    <title>Edit Account</title>
    <link rel="stylesheet" href="styles/moreinfo.css">

</head>

<body>
    <a href="home.html"><img src="ITCLogoOutline.png" class="logo"></a>
    <div class="form">
        <h1>Tell us about Yourself!</h1>
        <form action="moreInfo.php" method="post" id="form">

            <div class="gender-container">
                <label id="gender" for="gender">Gender</label><br>
                <div class="spacer"></div>
                <div class="spacer"></div>
                <input class="midsized" type="radio" name="gender" value="female" class="gender">Female <br>
                <div class="spacer"></div>
                <input class="midsized" type="radio" name="gender" value="male" class="gender">Male <br>
                <div class="spacer"></div>
                <input class="midsized" type="radio" name="gender" value="other" class="gender">Other <br>
            </div>

            Description: Short bio (hobbies, reason for rooming, etc.) <br>
            <textarea class="midsized" name="desc" id="desc" cols="30" rows="10"></textarea> <br>
            <p class="midsized form-background">University</p> <br>
            <input class="midsized" type="text" name="university"> <br>
            <p class="midsized form-background">Major</p> <br>
            <input class="midsized" type="text" name="major"> <br>
            <div class="preferences-container">
                <label for="clean">How clean are you?</label><br>
                <select name="clean" id="clean">
                    <option value="">Select Option</option>
                    <option value="messy">Messy</option>
                    <option value="semi messy">Semi messy</option>
                    <option value="neutral">Neutral</option>
                    <option value="semi neat">Semi neat</option>
                    <option value="neat">Neat</option>
                </select>
            </div>
            <div class="preferences-container">
                <label for="smoking">Are you okay with smoking?</label><br>
                <select name="smoking" id="smoking">
                    <option value="">Select Option</option>
                    <option value="Yes">Yes</option>
                    <option value="No">No</option>
                </select>
            </div>
            <div class="preferences-container">
                <label for="drugs">Are you okay around drugs?</label><br>
                <select name="drugs" id="drugs">
                    <option value="">Select Option</option>
                    <option value="Yes">Yes</option>
                    <option value="No">No</option>
                </select>
            </div>
            <div class="preferences-container">
                <label for="sleep">On weekdays, at what times do you typically go to sleep?</label><br>
                <select name="weekdaySleep" id="sleep">
                    <option value="">Select Option</option>
                    <option value="8-10">8pm - 10pm</option>
                    <option value="10-12">10pm - Midnight</option>
                    <option value="12+">Past Midnight</option>
                </select>
            </div>
            <div class="preferences-container">
                <label for="sleep">On weekends, at what times do you typically go to sleep?</label><br>
                <select name="weekendSleep" id="sleep">
                    <option value="">Select Option</option>
                    <option value="8-10">8pm - 10pm</option>
                    <option value="10-12">10pm - Midnight</option>
                    <option value="12+">Past Midnight</option>
                </select>
            </div>
            <div class="preferences-container">
                <label for="noise">How loud/quiet would you like your environment to be?</label><br>
                <select name="noise" id="noise">
                    <option value="">Select Option</option>
                    <option value="very loud">Very loud</option>
                    <option value="loud">Loud</option>
                    <option value="neutral">Neutral</option>
                    <option value="quiet">Quiet</option>
                    <option value="silent">Silent</option>
                </select>
            </div>
            <div class="preferences-container">
                <label for="pets">Are you comfortable with having pets?</label><br>
                <select name="pets" id="pets">
                    <option value="">Select Option</option>
                    <option value="Yes">Yes</option>
                    <option value="No">No</option>
                </select>
            </div>
            <input type="submit" name="submit" value="Submit" class="button submit">
        </form>
    </div>

</body>