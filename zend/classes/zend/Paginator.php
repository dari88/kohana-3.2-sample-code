<?php
/**
 * Zend Framework
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://framework.zend.com/license/new-bsd
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@zend.com so we can send you a copy immediately.
 *
 * @category   Zend
 * @package    Zend_Paginator
 * @copyright  Copyright (c) 2005-2011 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 * @version    $Id: Paginator.php 23775 2011-03-01 17:25:24Z ralph $
 */

/**
 * @see Zend_Loader_PluginLoader
 */
// require_once 'Zend/Loader/PluginLoader.php';

/**
 * @see Zend_Json
 */
// require_once 'Zend/Json.php';

/**
 * @category   Zend
 * @package    Zend_Paginator
 * @copyright  Copyright (c) 2005-2011 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */
class Zend_Paginator implements Countable, IteratorAggregate
{
    /**
     * The cache tag prefix used to namespace Paginator results in the cache
     *
     */
    const CACHE_TAG_PREFIX = 'Zend_Paginator_';

    /**
     * Configuration file
     *
     * @var Zend_Config
     */
    protected static $_config = null;

    /**
     * Default scrolling style
     *
     * @var string
     */
    protected static $_defaultScrollingStyle = 'Sliding';

    /**
     * Default item count per page
     *
     * @var int
     */
    protected static $_defaultItemCountPerPage = 10;

    /**
     * Default number of local pages (i.e., the number of discretes
     * page numbers that will be displayed, including the current
     * page number)
     *
     * @var int
     */
    protected static $_defaultPageRange = 10;

    /**
     * Cache object
     *
     * @var Zend_Cache_Core
     */
    protected static $_cache;

    /**
     * Enable or disable the cache by Zend_Paginator instance
     *
     * @var bool
     */
    protected $_cacheEnabled = true;

    /**
     * Adapter
     *
     * @var Zend_Paginator_Adapter_Interface
     */
    protected $_adapter = null;

    /**
     * Number of items in the current page
     *
     * @var integer
     */
    protected $_currentItemCount = null;

    /**
     * Current page items
     *
     * @var Traversable
     */
    protected $_currentItems = null;

    /**
     * Current page number (starting from 1)
     *
     * @var integer
     */
    protected $_currentPageNumber = 1;

    /**
     * Result filter
     *
     * @var Zend_Filter_Interface
     */
    protected $_filter = null;

    /**
     * Number of items per page
     *
     * @var integer
     */
    protected $_itemCountPerPage = null;

    /**
     * Number of pages
     *
     * @var integer
     */
    protected $_pageCount = null;

    /**
     * Number of local pages (i.e., the number of discrete page numbers
     * that will be displayed, including the current page number)
     *
     * @var integer
     */
    protected $_pageRange = null;

    /**
     * Pages
     *
     * @var array
     */
    protected $_pages = null;

    /**
     * Factory.
     *
     * @param  mixed $data
     * @param  string $adapter
     * @param  array $prefixPaths
     * @return Zend_Paginator
     */
    public static function factory($data)
    {
            return new self(new Zend_Paginator_Adapter_Iterator($data));
    }

    /**
     * Returns the default scrolling style.
     *
     * @return  string
     */
    public static function getDefaultScrollingStyle()
    {
        return self::$_defaultScrollingStyle;
    }

    /**
     * Get the default item count per page
     *
     * @return int
     */
    public static function getDefaultItemCountPerPage()
    {
        return self::$_defaultItemCountPerPage;
    }

    /**
     * Set the default item count per page
     *
     * @param int $count
     */
    public static function setDefaultItemCountPerPage($count)
    {
        self::$_defaultItemCountPerPage = (int) $count;
    }

    /**
     * Get the default page range
     *
     * @return int
     */
    public static function getDefaultPageRange()
    {
        return self::$_defaultPageRange;
    }

    /**
     * Set the default page range
     *
     * @param int $count
     */
    public static function setDefaultPageRange($count)
    {
        self::$_defaultPageRange = (int) $count;
    }

    /**
     * Sets a cache object
     *
     * @param Zend_Cache_Core $cache
     */
    public static function setCache(Zend_Cache_Core $cache)
    {
        self::$_cache = $cache;
    }

    /**
     * Sets the default scrolling style.
     *
     * @param  string $scrollingStyle
     */
    public static function setDefaultScrollingStyle($scrollingStyle = 'Sliding')
    {
        self::$_defaultScrollingStyle = $scrollingStyle;
    }

    /**
     * Constructor.
     *
     * @param Zend_Paginator_Adapter_Interface|Zend_Paginator_AdapterAggregate $adapter
     */
    public function __construct($adapter)
    {
        if ($adapter instanceof Zend_Paginator_Adapter_Interface) {
            $this->_adapter = $adapter;
        } else {
            throw new Exception(
                'Zend_Paginator only accepts instances of the type ' .
                'Zend_Paginator_Adapter_Interface.'
            );
        }

        $config = self::$_config;

        if ($config != null) {
            $setupMethods = array('ItemCountPerPage', 'PageRange');

            foreach ($setupMethods as $setupMethod) {
                $value = $config->get(strtolower($setupMethod));

                if ($value != null) {
                    $setupMethod = 'set' . $setupMethod;
                    $this->$setupMethod($value);
                }
            }
        }
    }

    /**
     * Enables/Disables the cache for this instance
     *
     * @param bool $enable
     * @return Zend_Paginator
     */
    public function setCacheEnabled($enable)
    {
        $this->_cacheEnabled = (bool)$enable;
        return $this;
    }

    /**
     * Returns the number of pages.
     *
     * @return integer
     */
    public function count()
    {
        if (!$this->_pageCount) {
            $this->_pageCount = $this->_calculatePageCount();
        }

        return $this->_pageCount;
    }

    /**
     * Returns the total number of items available.
     *
     * @return integer
     */
    public function getTotalItemCount()
    {
        return count($this->getAdapter());
    }

    /**
     * Clear the page item cache.
     *
     * @param int $pageNumber
     * @return Zend_Paginator
     */
    public function clearPageItemCache($pageNumber = null)
    {
        if (!$this->_cacheEnabled()) {
            return $this;
        }

        if (null === $pageNumber) {
            foreach (self::$_cache->getIdsMatchingTags(array($this->_getCacheInternalId())) as $id) {
                if (preg_match('|'.self::CACHE_TAG_PREFIX."(\d+)_.*|", $id, $page)) {
                    self::$_cache->remove($this->_getCacheId($page[1]));
                }
            }
        } else {
            $cleanId = $this->_getCacheId($pageNumber);
            self::$_cache->remove($cleanId);
        }
        return $this;
    }

    /**
     * Returns the absolute item number for the specified item.
     *
     * @param  integer $relativeItemNumber Relative item number
     * @param  integer $pageNumber Page number
     * @return integer
     */
    public function getAbsoluteItemNumber($relativeItemNumber, $pageNumber = null)
    {
        $relativeItemNumber = $this->normalizeItemNumber($relativeItemNumber);

        if ($pageNumber == null) {
            $pageNumber = $this->getCurrentPageNumber();
        }

        $pageNumber = $this->normalizePageNumber($pageNumber);

        return (($pageNumber - 1) * $this->getItemCountPerPage()) + $relativeItemNumber;
    }

    /**
     * Returns the adapter.
     *
     * @return Zend_Paginator_Adapter_Interface
     */
    public function getAdapter()
    {
        return $this->_adapter;
    }

    /**
     * Returns the number of items for the current page.
     *
     * @return integer
     */
    public function getCurrentItemCount()
    {
        if ($this->_currentItemCount === null) {
            $this->_currentItemCount = $this->getItemCount($this->getCurrentItems());
        }

        return $this->_currentItemCount;
    }

    /**
     * Returns the items for the current page.
     *
     * @return Traversable
     */
    public function getCurrentItems()
    {
        if ($this->_currentItems === null) {
            $this->_currentItems = $this->getItemsByPage($this->getCurrentPageNumber());
        }

        return $this->_currentItems;
    }

    /**
     * Returns the current page number.
     *
     * @return integer
     */
    public function getCurrentPageNumber()
    {
        return $this->normalizePageNumber($this->_currentPageNumber);
    }

    /**
     * Sets the current page number.
     *
     * @param  integer $pageNumber Page number
     * @return Zend_Paginator $this
     */
    public function setCurrentPageNumber($pageNumber)
    {
        $this->_currentPageNumber = (integer) $pageNumber;
        $this->_currentItems      = null;
        $this->_currentItemCount  = null;

        return $this;
    }

    /**
     * Get the filter
     *
     * @return Zend_Filter_Interface
     */
    public function getFilter()
    {
        return $this->_filter;
    }

    /**
     * Set a filter chain
     *
     * @param Zend_Filter_Interface $filter
     * @return Zend_Paginator
     */
    public function setFilter(Zend_Filter_Interface $filter)
    {
        $this->_filter = $filter;

        return $this;
    }

    /**
     * Returns an item from a page.  The current page is used if there's no
     * page sepcified.
     *
     * @param  integer $itemNumber Item number (1 to itemCountPerPage)
     * @param  integer $pageNumber
     * @return mixed
     */
    public function getItem($itemNumber, $pageNumber = null)
    {
        if ($pageNumber == null) {
            $pageNumber = $this->getCurrentPageNumber();
        } else if ($pageNumber < 0) {
            $pageNumber = ($this->count() + 1) + $pageNumber;
        }

        $page = $this->getItemsByPage($pageNumber);
        $itemCount = $this->getItemCount($page);

        if ($itemCount == 0) {
            throw new Exception('Page ' . $pageNumber . ' does not exist');
        }

        if ($itemNumber < 0) {
            $itemNumber = ($itemCount + 1) + $itemNumber;
        }

        $itemNumber = $this->normalizeItemNumber($itemNumber);

        if ($itemNumber > $itemCount) {
            throw new Exception('Page ' . $pageNumber . ' does not'
                                 . ' contain item number ' . $itemNumber);
        }

        return $page[$itemNumber - 1];
    }

    /**
     * Returns the number of items per page.
     *
     * @return integer
     */
    public function getItemCountPerPage()
    {
        if (empty($this->_itemCountPerPage)) {
            $this->_itemCountPerPage = self::getDefaultItemCountPerPage();
        }

        return $this->_itemCountPerPage;
    }

    /**
     * Sets the number of items per page.
     *
     * @param  integer $itemCountPerPage
     * @return Zend_Paginator $this
     */
    public function setItemCountPerPage($itemCountPerPage = -1)
    {
        $this->_itemCountPerPage = (integer) $itemCountPerPage;
        if ($this->_itemCountPerPage < 1) {
            $this->_itemCountPerPage = $this->getTotalItemCount();
        }
        $this->_pageCount        = $this->_calculatePageCount();
        $this->_currentItems     = null;
        $this->_currentItemCount = null;

        return $this;
    }

    /**
     * Returns the number of items in a collection.
     *
     * @param  mixed $items Items
     * @return integer
     */
    public function getItemCount($items)
    {
        $itemCount = 0;

        if (is_array($items) || $items instanceof Countable) {
            $itemCount = count($items);
        } else { // $items is something like LimitIterator
            $itemCount = iterator_count($items);
        }

        return $itemCount;
    }

    /**
     * Returns the items for a given page.
     *
     * @return Traversable
     */
    public function getItemsByPage($pageNumber)
    {
        $pageNumber = $this->normalizePageNumber($pageNumber);

        if ($this->_cacheEnabled()) {
            $data = self::$_cache->load($this->_getCacheId($pageNumber));
            if ($data !== false) {
                return $data;
            }
        }

        $offset = ($pageNumber - 1) * $this->getItemCountPerPage();

        $items = $this->_adapter->getItems($offset, $this->getItemCountPerPage());

        $filter = $this->getFilter();

        if ($filter !== null) {
            $items = $filter->filter($items);
        }

        if (!$items instanceof Traversable) {
            $items = new ArrayIterator($items);
        }

        if ($this->_cacheEnabled()) {
            self::$_cache->save($items, $this->_getCacheId($pageNumber), array($this->_getCacheInternalId()));
        }

        return $items;
    }

    /**
     * Returns a foreach-compatible iterator.
     *
     * @return Traversable
     */
    public function getIterator()
    {
        return $this->getCurrentItems();
    }

    /**
     * Returns the page range (see property declaration above).
     *
     * @return integer
     */
    public function getPageRange()
    {
        if (null === $this->_pageRange) {
            $this->_pageRange = self::getDefaultPageRange();
        }

        return $this->_pageRange;
    }

    /**
     * Sets the page range (see property declaration above).
     *
     * @param  integer $pageRange
     * @return Zend_Paginator $this
     */
    public function setPageRange($pageRange)
    {
        $this->_pageRange = (integer) $pageRange;

        return $this;
    }

    /**
     * Returns the page collection.
     *
     * @param  string $scrollingStyle Scrolling style
     * @return array
     */
    public function getPages($scrollingStyle = null)
    {
        if ($this->_pages === null) {
            $this->_pages = $this->_createPages($scrollingStyle);
        }

        return $this->_pages;
    }

    /**
     * Returns a subset of pages within a given range.
     *
     * @param  integer $lowerBound Lower bound of the range
     * @param  integer $upperBound Upper bound of the range
     * @return array
     */
    public function getPagesInRange($lowerBound, $upperBound)
    {
        $lowerBound = $this->normalizePageNumber($lowerBound);
        $upperBound = $this->normalizePageNumber($upperBound);

        $pages = array();

        for ($pageNumber = $lowerBound; $pageNumber <= $upperBound; $pageNumber++) {
            $pages[$pageNumber] = $pageNumber;
        }

        return $pages;
    }

    /**
     * Returns the page item cache.
     *
     * @return array
     */
    public function getPageItemCache()
    {
        $data = array();
        if ($this->_cacheEnabled()) {
            foreach (self::$_cache->getIdsMatchingTags(array($this->_getCacheInternalId())) as $id) {
                    if (preg_match('|'.self::CACHE_TAG_PREFIX."(\d+)_.*|", $id, $page)) {
                        $data[$page[1]] = self::$_cache->load($this->_getCacheId($page[1]));
                    }
            }
        }
        return $data;
    }

    /**
     * Brings the item number in range of the page.
     *
     * @param  integer $itemNumber
     * @return integer
     */
    public function normalizeItemNumber($itemNumber)
    {
        $itemNumber = (integer) $itemNumber;

        if ($itemNumber < 1) {
            $itemNumber = 1;
        }

        if ($itemNumber > $this->getItemCountPerPage()) {
            $itemNumber = $this->getItemCountPerPage();
        }

        return $itemNumber;
    }

    /**
     * Brings the page number in range of the paginator.
     *
     * @param  integer $pageNumber
     * @return integer
     */
    public function normalizePageNumber($pageNumber)
    {
        $pageNumber = (integer) $pageNumber;

        if ($pageNumber < 1) {
            $pageNumber = 1;
        }

        $pageCount = $this->count();

        if ($pageCount > 0 && $pageNumber > $pageCount) {
            $pageNumber = $pageCount;
        }

        return $pageNumber;
    }

    /**
     * Tells if there is an active cache object
     * and if the cache has not been desabled
     *
     * @return bool
     */
    protected function _cacheEnabled()
    {
        return ((self::$_cache !== null) && $this->_cacheEnabled);
    }

    /**
     * Makes an Id for the cache
     * Depends on the adapter object and the page number
     *
     * Used to store item in cache from that Paginator instance
     *  and that current page
     *
     * @param int $page
     * @return string
     */
    protected function _getCacheId($page = null)
    {
        if ($page === null) {
            $page = $this->getCurrentPageNumber();
        }
        return self::CACHE_TAG_PREFIX . $page . '_' . $this->_getCacheInternalId();
    }

    /**
     * Get the internal cache id
     * Depends on the adapter and the item count per page
     *
     * Used to tag that unique Paginator instance in cache
     *
     * @return string
     */
    protected function _getCacheInternalId()
    {
        return md5(serialize(array(
            $this->getAdapter(),
            $this->getItemCountPerPage()
        )));
    }

    /**
     * Calculates the page count.
     *
     * @return integer
     */
    protected function _calculatePageCount()
    {
        return (integer) ceil($this->getAdapter()->count() / $this->getItemCountPerPage());
    }

    /**
     * Creates the page collection.
     *
     * @param  string $scrollingStyle Scrolling style
     * @return stdClass
     */
    protected function _createPages($scrollingStyle = null)
    {
        $pageCount         = $this->count();
        $currentPageNumber = $this->getCurrentPageNumber();

        $pages = new stdClass();
        $pages->pageCount        = $pageCount;
        $pages->itemCountPerPage = $this->getItemCountPerPage();
        $pages->first            = 1;
        $pages->current          = $currentPageNumber;
        $pages->last             = $pageCount;

        // Previous and next
        if ($currentPageNumber - 1 > 0) {
            $pages->previous = $currentPageNumber - 1;
        }

        if ($currentPageNumber + 1 <= $pageCount) {
            $pages->next = $currentPageNumber + 1;
        }

        // Pages in range
        $scrollingStyle = $this->_loadScrollingStyle($scrollingStyle);
        $pages->pagesInRange     = $scrollingStyle->getPages($this);
        $pages->firstPageInRange = min($pages->pagesInRange);
        $pages->lastPageInRange  = max($pages->pagesInRange);

        // Item numbers
        if ($this->getCurrentItems() !== null) {
            $pages->currentItemCount = $this->getCurrentItemCount();
            $pages->itemCountPerPage = $this->getItemCountPerPage();
            $pages->totalItemCount   = $this->getTotalItemCount();
            $pages->firstItemNumber  = (($currentPageNumber - 1) * $this->getItemCountPerPage()) + 1;
            $pages->lastItemNumber   = $pages->firstItemNumber + $pages->currentItemCount - 1;
        }

        return $pages;
    }

    /**
     * Loads a scrolling style.
     *
     * @param string $scrollingStyle
     * @return Zend_Paginator_ScrollingStyle_Interface
     */
    protected function _loadScrollingStyle($scrollingStyle = null)
    {
        if ($scrollingStyle === null) {
            $scrollingStyle = self::$_defaultScrollingStyle;
        }

        switch (strtolower($scrollingStyle)) {
            case 'all':
            case 'elastic':
            case 'jumping':
            case 'sliding':
                $className = 'Zend_Paginator_ScrollingStyle_'.$scrollingStyle;
                return new $className();

            case 'null':
            default:
                throw new Exception('Scrolling style must be a class ' .
                  'name or object implementing Zend_Paginator_ScrollingStyle_Interface');
        }
    }
}
