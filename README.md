## holiday
```text
获取中国法定假期日历
```

### 用法

```shell
# 下载项目
git clone https://github.com/quansitech/holiday.git

# 执行命令，获取日历数据json
# 年份范围 2010-下一年
# 已经获取过的年份数据会写入文件，文件名为 /src/Calendar/year_calendar.json

php ./holiday.php 2023
```

#### 返回数据说明示例
```php
[
  ...
  {
    "date": "2022-12-26",
    "year": 2022,
    "month": 12,
    "day": 26,
    "status": 0
  }
   ...
]
```


| 名称              | 类型                | 说明                                  |
|:----------------|:------------------|-------------------------------------|
| date            | string            | 日期                                  |
| year            | int               | 年                                   |
| month           | int               | 月                                   |
| day             | int               | 日                                   |
| status          | int               | 假期标识：0普通工作日 1周末双休日 2需要补班的工作日 3法定节假日 |


### 其它说明
[日期数据来源](http://api.haoshenqi.top/holiday?date=2022)
