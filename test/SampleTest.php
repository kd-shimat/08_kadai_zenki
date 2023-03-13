
<?php

use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use PHPUnit\Framework\TestCase;
use Facebook\WebDriver\WebDriverExpectedCondition;
use Facebook\WebDriver\WebDriverBy;

class SampleTest extends TestCase
{

    protected $pdo;// PDOオブジェクト用のプロパティ(メンバ変数)の宣言
    protected $driver; 

    public function setUp(): void {
        // PDOオブジェクトを生成し、データベースに接続
        $dsn = "mysql:host=db;dbname=php;charset=utf8";
        $user = "kobe";
        $password = "denshi";
        try {
            $this->pdo = new PDO($dsn, $user, $password);
        } catch(Exception $e){
            echo 'Error:' . $e->getMessage( );
            die();
        }

        // chrome ドライバーの起動
        $host = 'http://172.17.0.1:4444/wd/hub'; #Github Actions上で実行可能なHost
        //$host = 'http://host.docker.internal:4444/wd/hub'; #Github Actions上で実行可能なHost
        // chrome ドライバーの起動
        $this->driver = RemoteWebDriver::create($host,DesiredCapabilities::chrome());
    }

    public function test_returnPerson()
    {
        #XAMPP環境で実施している場合、$dsn設定を変更する必要がある
        //ファイルパス
        $rdfile = __DIR__ .'/../src/dbselect.php';
        $val = "mysql:host=db;dbname=php;charset=utf8";
        
        //ファイルの内容を全て文字列に読み込む
        $str = file_get_contents($rdfile);
        
        //検索文字列に一致したすべての文字列を置換する
        $str = str_replace("mysql:host=localhost;dbname=php;charset=utf8", $val, $str);
        
        //文字列をファイルに書き込む
        file_put_contents($rdfile, $str);

        // 指定URLへ遷移 (Google)
        $this->driver->get('http://php/src/dbselect.php');
        // プルダウンの値を取得
        // $elements = $this->driver->findElements(WebDriverBy::xpath('//html/body/p'));
        $elements = $this->driver->findElements(WebDriverBy::tagName('p'));

        //データベースの値を取得
        $sql = 'select  *  from  person';									// SQL文の定義	
        $stmt = $this->pdo->query($sql);                                    // SELECT文の実行
        $count = $stmt -> rowCount();                                    // レコード数の取得										
        $results = $stmt->fetchAll( );									    // 実行結果を連想配列の形で取り出す	
        												                    // データベースへの接続を閉じる
        
        
        var_dump($elements);
        for($i=0;$i<$count;$i++){
            $this->assertStringContainsString($results[$i]['name'], $elements[$i]->getText());
        }
        
        // foreach(array_map(NULL, $results, $elements) as [ $result, $element ]){
        //     //assert
        //     $this->assertStringContainsString($result['name'], $element->getText());
        // }

        // DBの接続を解除
        $this->pdo = null;
        // ブラウザを閉じる
        $this->driver->close();
    }
}
