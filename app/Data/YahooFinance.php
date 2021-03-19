<?php


namespace App\Data;


class YahooFinance
{
    /**
     * Base Url
     */
    public const API_BASE_URL = 'https://apidojo-yahoo-finance-v1.p.rapidapi.com';

    /**
     * Historical
     */
    public const STOCK_HISTORICAL = '/stock/v3/get-historical-data?region=US&symbol=';

    /**
     * Summary
     */
    public const STOCK_SUMMARY = '/stock/v2/get-summary?region=US&symbol=';

    /**
     * Statisticks
     */
    public const STOCK_STATISTICS = '/stock/v2/get-statistics?region=US&symbol=';

    /**
     * Keys
     */
    public const API_HOST_ENV = 'YAHOO_FINANCE_API_HOST';

    public const API_KEY_ENV = 'YAHOO_FINANCE_API_KEY';
}
