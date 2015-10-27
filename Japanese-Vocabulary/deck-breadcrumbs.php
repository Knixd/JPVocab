<div class="container-fluid">
	<div class="row" itemprop="breadcrumb">
		<ol class="breadcrumb" itemprop="breadcrumb" itemscope itemtype="http://schema.org/BreadcrumbList">
		  <li itemprop="itemListElement" 
			itemscope itemtype="http://schema.org/ListItem">
			<a href="http://www.JPVocab.com/" title="Home" itemprop="item">
			<span itemprop="name">Home</span></a>
			<meta itemprop="position" content="1" />
		</li>
		  <!--<li itemprop="itemListElement" 
			itemscope itemtype="http://schema.org/ListItem">
			<a href="http://www.JPVocab.com/quiz.php" title="Japanese Flashcards" itemprop="item">
			<span itemprop="name">Japanese Flashcards</span></a>
			<meta itemprop="position" content="2" />
		</li>-->
		  <li itemprop="itemListElement" 
			itemscope itemtype="http://schema.org/ListItem">
			<a href="http://www.JPVocab.com/unlock.php" title="Unlock Japanese Flashcards" itemprop="item">
			<span itemprop="name">Deck Types</span></a>
			<meta itemprop="position" content="2" />
		</li>
		  <li itemprop="itemListElement" 
			itemscope itemtype="http://schema.org/ListItem"
			<?php if($d == "no deck set"){ echo "class='active'";}?>><?php if($d == "no deck set"){echo $t;}else{?><a href="http://www.JPVocab.com/Japanese-Vocabulary/deck.php?t=<?php echo $t;?>"  title="Japanese Flashcard Deck" itemprop="item">
			<span itemprop="name"><?php echo $t;?> Decks</a><?php }?></span>
			<meta itemprop="position" content="3" />
		</li><?php
			if($d != "no deck set"){?>
				<li  itemprop="itemListElement" 
					itemscope itemtype="http://schema.org/ListItem" class="active">
					<span  itemprop="item"><span itemprop="name"><?php echo $d['display_name'];?></span></span>
					<meta itemprop="position" content="4" /></li><?php
			}?>
		</ol>
	</div>
</div>