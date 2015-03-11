# I Like it Here
## By: HackBlitz
Aarin Smith
Andrew Hartline
Sean Hodgkinson
Thanh-Chau Pham (Edwin)

##  Demo Wearable Application for POF Hackathon
Proof of concept application for I Like It Here location based matching system.
Consists of simple wearable application that runs in conjuction with a service on
Android handheld device, as well as a demo Web app to demonstrate matching.

## Concept
The initial idea was to create an application that assisted in matching two
potential partners based on frequently visited locations. The places people
like can say a lot about them and we felt the wearable was the perfect platform for
this concept. We decided to use the limitations given by a wearable device to
our advantage by limiting the UI to a simple "I like it here" button. This allows the
user to easily save locations to a profile, and a simple matching metric is
implemented on the server side to show potential matches.

## How it works
When a user clicks the "I like it here" button on the phone, a message is sent to
the accompanying mobile device that hosts a service listening for this message.
When the message is received the device grabs the current lat / long and queries
the Google Places API for the nearest location (see possible future features).
The Google placeId is stored in a database and retrieved by a web app which
uses a very basic algorithm to match potential partners based on placeId.

## Possible future features
Currently the device just grabs the nearest location. In the future it may be
nice to implement a quick list through the nearest location, possibly an "Are
you here?" dialog" with a yes or no response.
Liking locations multiple times could be a future implementation maybe -
"I REALLY like it here". How this would affect the current metric would be
up to the developer to implement.
Run the mobile side as more then just a background service. Browse matches etc.

## Benefits
We feel that location is a great method to match on. It's easy to click a single
button. And over time these could add up to create a very comprehensive system
of matching. As well as creating a large dataset of personalized information.
Data mining / targeted marketing.
Plus the clients get the added benefit of never wondering where to go on a date!

## Source Code
ILIHere folder contains android project that runs on both the mobile and the
wearable.

I_LIKE_IT_HERE folder contains source code for Web App written in CodeIgniter
with a prepopulated SampleDB.sql file to seed some mock data.

live sample site viewable at:

ilih.aarinsmith.com
