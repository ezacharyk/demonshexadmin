# Demon's Hex Admin Application

This project was the start to an online card game's administration system. The game was meant to be an online multiplayer card game similar to Final Fantasy's Triple Triad card game.

This administration system was used to design tokens to be used in the playing of the game. It was also planned to be a backend for managing players and their data.

The system was written many years ago and I have not tested it in recent versions of PHP and MySQL, but it was designed using those tools. I think this system would be much better had I developed it using a Framework such as Laravel or something similar available at the time. 

This project provided a method to log in as an administrator and from there, create other administrators, and create tokens. 

# Creating Users

When creating users, you provide an email, user name, password and status. Those users were then able to log in and perform the same tasks. You could also edit users to revoke access and change their password.

# Creating tokens

The Tokens were the main aspect of this game. Each token was created by giving the token a name, attack and defense stats, assigning attack directions and uploading a face image. The system would then save that data in the database and compile the data into an image that would then be imported into the game itself. The creation and editing of tokens is all that was functional at the time. 

# Future of this Project
This project is effectively dead. I have little interest in resurrecting it, at least in this format. I have since learned better ways of achieving the goals of this application and have since lost interest in the idea of online multiplayer games development. 

While this project is fun to look at at this time, I don't see much value in bringing it back.