# Roommate Finder Application
Technologies: VSCode, MySQL, HTML, CSS, Javascript, PHP
- Important Note: We could not get a published website working that was integrated my MySQL and PHP. Because of this, our PHP server is hosted locally and the MySQL server is hosted with AWS. Running our website will most likely require having some specific files downloaded and a PHP server that is available.
- Because of this, we have provided a video that showcases our website working correctly. https://youtu.be/8tWCqV2fUMY

## Architecture and Design
- Home Page: The default home page for our website. A place where a user can either choose to login or create an account.
- Create Account Page: The page a new user accesses to create their account. Name, email, and password are required. Text fields include input validation, duplicate email checking, and password strength + encryption.
- Login Page: The page a user accesses to login to their account. Upon a successful login, the user is moved into their user's homepage.
- User's Home Page: A page where users can see information about themselves. If the user logs in for the first time, they will be redirected to the Edit Account page.
- Edit Account Page: A page where users can input / update their preferences and descriptions about themself. 
- Search Page: A page where users can search for other people using university as the search option. Information is displayed about the user, and their email is clickable to send the user to the clicked user's biography.
- Profile Page: A page where a user can see another user's information, such as their preferences.

## Database Design and Table Relationships
Our database contains three tables, 'account', 'preference', and 'preferencevalues'.
The account table has information related to the user, and the preference table shares a 1 to 1 relationship with account. 
The preference table holds information that stores the preferences of a user, and shares a 1 to 1 relationship with preferencevalues.
The preferencevalues table simply holds numerical values of the preferences for later usage.
The splitting of preferences into two tables allows for easy access of both the user's preferences and the weights of said preferences when calculating similarity.

## Required Features
- 1: User is able to create an account on the website where they can create a roommate profile. This includes their name, email, bio, university, major, and questions/attributes to identify roommate compatibility.
- 2: User is able to search for other roommates using a university as the search keyword. A similarity percentage is also displayed, and a user can find more information about a specific user.
- 3: A profile page exists that allows other users to view someone else's roommate profile. Information about them are displayed.

## Bonus Features
- 1: Implemented a similarity algorithm that allows roommates to gauge how similar they are to another roommate for a higher probability of a success.
- 2: Implemented a way to change information about your account (such as preferences, bio, etc) after account creation
