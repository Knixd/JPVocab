# About the JPVocab Project
These purpose of these files were to create an online text-based browser game to make Japanese flashcard drills less cumbersome. You can see it live here: [JPVocab.com](http://www.JPVocab.com)
##Main Features
1. Player experience system,
2. Player currency system,
3. Premium currency system (taken off of live site),
4. Simple Marketplace system,
5. Player skill item leveling system,
6. Simple PVP combat system with PVP Battle Leaderboard,
7. Records framework for future machine learning exercises

##History
JPVocab is the result of an extreme streamlining of it's predecessor [tehJapanesesite.com](http://www.tehJapanesesite.com). This predecessor was vaguely named because its initial intention was to be a central hub for many Japanese language learning functions such as
* Japanese flashcards
* Japanese grammar drills
* Japanese verb conjugator
* Japanese language learning forum
* Japanese blog
* Japanese grammar explanations
* Japanese language learning games
* ...

It was discovered that site visitors thought the purpose of the site to be vague. I realized the site doing a little of everything but not particularly well. I reacted by breaking the site a part into specialized sites.

The forum, blog, Japanese verb conjugator, and grammar explanations were erased from the public eye and exist only on my harddrives. Its main two functions were then given their own domains to better described their purpose: [JPVocab.com](http://www.JPVocab.com) and [JPDrills.com](http://www.JPDrills.com).
* [JPDrills.com](http://www.JPDrills.com) also has a github repo [here](https://github.com/Knixd/JPDrills)

##Design
The design is intentionally simple and minimalist. I had originally written all css from scratch. I bumped into an experienced web developer/designer who suggested I check out using templating frameworks. I researched frameworks, decided to use [Bootstrap](http://getbootstrap.com/), and haven't looked back.

All future design must be minimalist and serve the function of language learner needs first. UI and UX is very important because these sites are tools whose functions are to be used over and over.

##Future Upgrades That You Could Help With
####PVP
1. The PVP battle arena needs better visuals,
2. The Combat results and combat log need a severe visual upgrade
  * Attack results could be delayed and displayed line by line
  * Attack results could have a progress bar decreasing each turn
  * Attack results could have an animation play for each turn
3. Players need avatars
4. Combat "algorithm" could be upgraded
5. Timers could be added to training times
6. Timers or Daily turns could be added to limit attacks on other players per day

####PVE
1. A linear set of increasingly harder bosses can be established
  * User battles a string of bosses and sees how far they can get.
  * Leaderboard displaying your farthest boss
2. A map and locations can be developed
3. A story to tie everything together can be established (I have one in the works)
4. A Choose-Your-Own-Adventure series 
  * Try to survive and keep the story going.
  * Share your story to fb

####Flashcard Decks
1. Need more flashcard decks
2. Need audio files for words
  * Framework is in place for audio flashcards but we need copyright free audio
3. Could put images for each card
  * Framework NOT YET in place, but could easily be added if user interest is there.
4. If audio and images are added to each card, flashcard layout needs to be redesigned
5. Could redesign results log of users flashcard guess
6. A user submitted flashcard deck marketplace system could be developed but would require severe hands-on QA (quality assurance)

####Players/Users
1. Could use a daily login reward system
2. Could display flashcard usage
  * Graphically display daily quantity of 'flashcards practiced' using google graphing api
3. Need player avatars
  * Could let them choose after registering
  * Could make a linear set of avatars that change into greater avatars as your player level progresses
  * Could use the premium currency framework to let people get cool avatars
4. Need to add player settings
  * Email notifications toggle for
    * PVP "You've been attacked" email
    * Daily login reminder
    * Weekly login reminder
    * Flashcard Rank "PlayerX just passed your flashcard rank. Login to reclaim your spot"
5. Could implement a referal reward system
