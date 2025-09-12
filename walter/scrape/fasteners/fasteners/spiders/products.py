import scrapy

class ProductsSpider(scrapy.Spider):
    name = 'products'
    allowed_domains = ['fastenersolutions.com']
    start_urls = ['https://www.fastenersolutions.com/']

    def parse(self, response):
        # Extract category links from nav_1 and nav_2 menu items
        category_links = response.xpath('//a[contains(@class, "nav_1") or contains(@class, "nav_2")]/@href').getall()

        # Limit to first 5 links for testing to avoid overwhelming the server
        for link in category_links[:5]:
            yield response.follow(link, self.parse_category)

    def parse_category(self, response):
        # Extract product links from category pages
        product_links = response.xpath('//a[contains(@class,"product-item-link")]/@href').getall()
        for link in product_links:
            yield response.follow(link, self.parse_product)

        # Handle pagination if exists
        next_page = response.xpath('//a[@class="next"]/@href').get()
        if next_page:
            yield response.follow(next_page, self.parse_category)

    def parse_product(self, response):
        title = response.xpath('//h1/text()').get()
        description = response.xpath('//div[@class="product.attribute.description"]//text()').getall()
        image = response.xpath('//img[@class="fotorama__img"]/@src').get()

        yield {
            'title': title.strip() if title else '',
            'description': ' '.join([d.strip() for d in description if d.strip()]),
            'image': image,
            'url': response.url,
        }