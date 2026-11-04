<?php
require 'includes/db.php';require 'includes/functions.php';
$q=trim($_GET['q']??'');$cat=trim($_GET['category']??'');$page=max(1,(int)($_GET['page']??1));$limit=8;$off=($page-1)*$limit;$w=[];$types='';$args=[];
if($q!==''){$w[]='(title LIKE ? OR author LIKE ? OR category LIKE ?)';$v="%$q%";array_push($args,$v,$v,$v);$types.='sss';}
if($cat!==''){$w[]='category=?';$args[]=$cat;$types.='s';}$where=$w?' WHERE '.implode(' AND ',$w):'';
$c=$conn->prepare('SELECT COUNT(*) FROM books'.$where);if($types)$c->bind_param($types,...$args);$c->execute();$total=(int)$c->get_result()->fetch_row()[0];
$s=$conn->prepare('SELECT * FROM books'.$where.' ORDER BY featured DESC,id DESC LIMIT ? OFFSET ?');$a=$args;$a[]=$limit;$a[]=$off;$s->bind_param($types.'ii',...$a);$s->execute();$books=$s->get_result();
$page_title='Home';include 'includes/header.php';?>
<section class="hero"><div><h1>Find your next<br>great read.</h1><p>Stories, ideas and inspiration for curious minds.</p><a class="btn" href="#books">Explore Books</a></div><div style="font-size:85px">📚</div></section>
<div class="promo">BOOKWEEK SPECIAL · Discover your next favourite book today!</div>
<form class="search" method="get"><input name="q" value="<?=e($q)?>" placeholder="Search title, author or category"><button class="btn">Search</button></form>
<div class="categories"><a href="index.php">All Books</a><?php foreach(['Fiction','Technology','Business','Self Help'] as $x):?><a href="?category=<?=urlencode($x)?>"><?=e($x)?></a><?php endforeach;?></div>
<h2 id="books">Featured Books & Best Sellers</h2><div class="grid"><?php while($b=$books->fetch_assoc()):?><article class="card"><div class="cover">📖</div><h3><?=e($b['title'])?></h3><p class="muted"><?=e($b['author'])?> · <?=e($b['category'])?></p><p class="price"><?=cash($b['price'])?></p><p class="muted">Stock: <?=$b['stock']?></p><a class="btn" href="book.php?id=<?=$b['id']?>">View Details</a></article><?php endwhile;?></div>
<?php if(!$total):?><p class="notice">No books found.</p><?php endif;?><div class="pagination"><?php for($i=1;$i<=max(1,ceil($total/$limit));$i++):?><a href="?<?=http_build_query(['q'=>$q,'category'=>$cat,'page'=>$i])?>"><?=$i?></a><?php endfor;?></div>
<?php include 'includes/footer.php';?>
