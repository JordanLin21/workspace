##### 2. 上面程式或規格可能存在什麼潛在問題？還可以怎樣優化？
1. 沒有記錄資料號源與時間
2. 資料增加狀態欄位記錄
3. error 時，DB記錄失敗資料或是重新放進queue

##### 3. 如果要加入第三家號源，會怎麼進行擴充？
1. App\Service\Crawler 新增 agent3
2. App\Service\Crawler\Crawler 增加 agent3 並調整順序

##### 4. 每個號源有不同的速率限制，會如何實現限流，防止被 ban？
1. 使用sleep
2. 使用 [Queues](https://laravel.com/docs/6.x/queues#rate-limiting)


##### 5. 開獎時間並非準時，您會如何實現重試機制？
1. 記錄未成功的資料
2. 排程讀DB重試

##### 6. 可以實現哪些手段來減少程式運行時間？
1. curl 增加 timeout
2. 用Queue背景處理
3. 排程伺服器建置在中國
4. SQL bulk update