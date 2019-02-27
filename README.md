# MDX Query builder

Provides convenient query builder for MDX. 
Supports several features of Mondrian MDX specification.

## Usage

Implement **ConnectionInterface** and pass it into **Query**.

You can use [Olap4Php](https://github.com/olap4php/olap4php) and pass MDX-string
build by **Query** class into **XMLAStatement**.

An example of query can look like this:

```php
$query = new Query($connection);

$dateRange = new DateRange(
    Carbon::parse('2019-01-01'),
    Carbon::parse('2019-01-31'),
    Period::DAY
);

$mdx = $query->select([
        '[Measures].[Retail Total]',
        '[Measures].[Profit]',
    ])
    ->by($dateRange)
    ->from('Sales')
    ->toMDX();
``` 

Resulting MDX is:

```sql
SELECT 

{[Measures].[Retail Total], [Measures].[Profit]} ON COLUMNS,

{
    {[Time].[2019].[Q1].[1].[W1].[D1] : [Time].[2019].[Q1].[1].[W5].[D31]}
} ON ROWS 

FROM [Sales]
```

TODO: Abstract Query class from Mondrian dialect
