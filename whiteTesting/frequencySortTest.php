<?php
declare(strict_types=1);
use PHPUnit\Framework\TestCase;

require_once '/home/student/Project2/csci310_Spring_P2/src/frequencySort.php';

final class frequencySortTest extends TestCase
{
    protected function setUp(){
        parent::setUp();
        $lyrics = ["Republican leaders in the Capitol meanwhile","have largely distanced themselves from the accusations as they attempt to focus on their own internal rifts that have hobbled the effort to repeal and replace Obamacare But Trumps accusations only added to a swirl of questions about Russia meddling in the 2016 elections already being investigated by House and Senate lawmakers"];
        $_POST['lyrics'] = $lyrics;
    }

    public function testCanGetCorrectFrequencyByGivenArray(){
        $input1 = ["abc","abc","abc","abc","bcd","bcd","bcd","abc","cde","cde"];
        $result1 = ["abc"=>5, "bcd"=>3, "cde"=>2];
        $this->assertEquals(getFrequency($input1), $result1);

        $input2 = ["abc","abc","abc","abc","bcd","bcd","bcd","abc","cde","cde"];
        $result2 = ["abc"=>5, "bcd"=>3, "cde"=>2];
        $this->assertEquals(getFrequency($input2), $result2);
    }

    public function testCanFilterBadWords(){
        $badWords = "after,again,against,ain't,all,allow,allows,almost,alone,along,already,also,although,always,am,among,amongst,an,and,another,any,anybody,anyhow,anyone,anything,anyway,anyways,anywhere,apart,appear,are,aren't,around,as,aside,ask,asking,at,available,away,be,became,because,become,becomes,becoming,been,before,beforehand,behind,being,believe,below,beside,besides,best,better,between,beyond,both,brief,but,by,c'mon,c's,came,can,can't,cannot,cant,cause,causes,certain,certainly,changes,clearly,co,com,come,comes,consequently,consider,considering,contain,containing,contains,corresponding,could,couldn't,course,currently,definitely,described,despite,did,didn't,different,do,does,doesn't,doing,don't,done,down,downwards,during,each,edu,eg,eight,either,else,elsewhere,enough,entirely,especially,et,etc,even,ever,every,everybody,everyone,everything,everywhere,ex,exactly,example,except,far,few,fifth,first,five,followed,for,former,formerly,forth,four,from,further,furthermore,get,gets,getting,given,gives,go,goes,going,gone,got,gotten,greetings,had,hadn't,happens,hardly,has,hasn't,have,haven't,having,he,he's,hello,help,hence,her,here,here's,hereafter,hereby,herein,hereupon,hers,herself,hi,him,himself,his,hither,hopefully,how,howbeit,however,i'd,i'll,i'm,i've,ie,if,ignored,immediate,in,inasmuch,inc,indeed,indicate,indicated,indicates,inner,insofar,instead,into,inward,is,isn't,it,it'd,it'll,it's,its,itself,just,keep,keeps,kept,know,knows,known,last,lately,later,latter,latterly,least,less,lest,let,let's,like,liked,likely,little,look,looking,looks,ltd,mainly,many,may,maybe,me,mean,meanwhile,merely,might,more,moreover,most,mostly,much,must,my,myself,name,namely,nd,near,nearly,necessary,need,needs,neither,never,nevertheless,new,next,nine,no,nobody,non,none,noone,nor,normally,not,nothing,novel,now,nowhere,obviously,of,off,often,oh,ok,okay,old,on,once,one,ones,only,onto,or,other,others,otherwise,ought,our,ours,ourselves,out,outside,over,overall,own,particular,particularly,per,perhaps,placed,please,plus,possible,presumably,probably,provides,que,quite,qv,rather,rd,re,really,reasonably,regarding,regardless,regards,relatively,respectively,right,said,same,saw,say,saying,says,second,secondly,see,seeing,seem,seemed,seeming,seems,seen,self,selves,sensible,sent,serious,seriously,seven,several,shall,she,should,shouldn't,since,six,so,some,somebody,somehow,someone,something,sometime,sometimes,somewhat,somewhere,soon,sorry,specified,specify,specifying,still,sub,such,sup,sure,t's,take,taken,tell,tends,th,than,thank,thanks,thanx,that,that's,thats,the,their,theirs,them,themselves,then,thence,there,there's,thereafter,thereby,therefore,therein,theres,thereupon,these,they,they'd,they'll,they're,they've,think,third,this,thorough,thoroughly,those,though,three,through,throughout,thru,thus,to,together,too,took,toward,towards,tried,tries,truly,try,trying,twice,two,un,under,unfortunately,unless,unlikely,until,unto,up,upon,us,use,used,useful,uses,using,usually,value,various,very,via,viz,vs,want,wants,was,wasn't,way,we,we'd,we'll,we're,we've,welcome,well,went,were,weren't,what,what's,whatever,when,whence,whenever,where,where's,whereafter,whereas,whereby,wherein,whereupon,wherever,whether,which,while,whither,who,who's,whoever,whole,whom,whose,why,will,willing,wish,with,within,without,won't,wonder,would,would've,wouldn't,yes,yet,you,you'd,you'll,you're,you've,your,yours,yourself,yourselves,zero,a,b,c,d,e,f,g,h,i,j,k,l,m,n,o,p,q,r,s,t,u,v,w,x,y,z";
        $badWords = explode(",", $badWords);
        // if exists
        $result1 = ["abc"];
        $input1 = ["abc"];
        $filteredWords = filterBadWords($input1, $badWords);
        $filteredWords = trimArray($filteredWords);
        $this->assertEquals($filteredWords, $result1);
        // if not exists
        $result2 = ["abc", "bcd"];
        $input2 = ["after", "abc", "bcd", "again", "a", "all"];
        $filteredWords = filterBadWords($input2, $badWords);
        $filteredWords = trimArray($filteredWords);
        $this->assertEquals($filteredWords, $result2);
    }

    public function testCanGetCorrectSortedListByInput(){
        // if result is an array which means it is not empty
        $input1 = "abc abc abc bcd bcd abc cde cde bcd def";
        $result1 =  [["word"=>"abc", "count"=>4], ["word"=>"bcd", "count"=>3], ["word"=>"cde", "count"=>2], ["word"=>"def", "count"=>1]];
        $this->assertEquals(getList($input1), $result1);

        // else if result is array of all trivial words
        $input2 = "again again almost already also always am among an ready";
        $result2 =  [["word"=>"ready", "count"=>1]];//[["word"=>"abc", "count"=>4], ["word"=>"bcd", "count"=>3], ["word"=>"cde", "count"=>2], ["word"=>"def", "count"=>1]];
        $this->assertEquals(getList($input2), $result2);
    }
}

function trimArray($A){
    $index = 0;
    $result = array();
    foreach($A as $v){
        if($v){
            $result[$index] = $v;
            $index = $index + 1;
        }
    }
    return $result;
}
