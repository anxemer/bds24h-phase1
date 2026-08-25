(function () {
    function initExistingListing(site) {
        var cards = Array.from(site.querySelectorAll('#bds-property-grid .bds-card'));
        var empty = site.querySelector('#bds-empty');
        var note = site.querySelector('#bds-results-note');
        var loadMore = site.querySelector('#bds-loadmore');
        var keyword = site.querySelector('#bds-keyword');
        var region = site.querySelector('#bds-region');
        var search = site.querySelector('#bds-search');
        var expanded = false;

        if (!cards.length || !empty || !note || !loadMore || !keyword || !region) return;

        function render() {
            var query = keyword.value.trim().toLowerCase();
            var selectedRegion = region.value;
            var visible = 0;

            cards.forEach(function (card) {
                var matchesRegion = selectedRegion === 'all' || card.dataset.region === selectedRegion;
                var matchesQuery = !query || (card.dataset.title || '').toLowerCase().includes(query) || card.textContent.toLowerCase().includes(query);
                var match = matchesRegion && matchesQuery;
                card.style.display = match && (expanded || visible < 6) ? '' : 'none';
                if (match) visible += 1;
            });

            empty.style.display = visible ? 'none' : 'block';
            note.textContent = visible + ' khu công nghiệp đang hiển thị · dữ liệu tham khảo từ Khoxuongdep.com.vn';
            loadMore.style.display = visible > 6 && !expanded ? 'block' : 'none';
        }

        if (search) {
            search.addEventListener('click', function () {
                expanded = true;
                render();
            });
        }
        keyword.addEventListener('input', render);
        region.addEventListener('change', render);
        loadMore.addEventListener('click', function (event) {
            event.preventDefault();
            expanded = true;
            render();
        });
        render();
    }

    function initKcnInventory(site) {
        var inventory = site.querySelector('#bds-kcn-inventory');
        if (!inventory || inventory.dataset.ready === 'true') return;
        inventory.dataset.ready = 'true';

        var cards = Array.from(inventory.querySelectorAll('.bds-kcn-card'));
        var tabs = Array.from(inventory.querySelectorAll('.bds-kcn-tab'));
        var keyword = inventory.querySelector('#bds-kcn-keyword');
        var region = inventory.querySelector('#bds-kcn-region');
        var size = inventory.querySelector('#bds-kcn-size');
        var note = inventory.querySelector('#bds-kcn-note');
        var empty = inventory.querySelector('#bds-kcn-empty');
        var activeCategory = 'all';

        function loadImage(image) {
            if (!image.dataset.src || image.classList.contains('is-loaded')) return;
            image.addEventListener('load', function () { image.classList.add('is-loaded'); }, { once: true });
            image.src = image.dataset.src;
        }

        if ('IntersectionObserver' in window) {
            var imageObserver = new IntersectionObserver(function (entries, observer) {
                entries.forEach(function (entry) {
                    if (!entry.isIntersecting) return;
                    loadImage(entry.target);
                    observer.unobserve(entry.target);
                });
            }, { rootMargin: '300px 0px' });
            inventory.querySelectorAll('img[data-src]').forEach(function (image) { imageObserver.observe(image); });
        } else {
            inventory.querySelectorAll('img[data-src]').forEach(loadImage);
        }

        function render() {
            var query = keyword.value.trim().toLowerCase();
            var selectedRegion = region.value;
            var selectedSize = size.value;
            var matches = 0;

            cards.forEach(function (card) {
                var matchesCategory = activeCategory === 'all' || card.dataset.category === activeCategory;
                var matchesRegion = selectedRegion === 'all' || card.dataset.region === selectedRegion;
                var matchesSize = selectedSize === 'all' || card.dataset.size === selectedSize;
                var matchesQuery = !query || (card.dataset.title || '').toLowerCase().includes(query) || card.textContent.toLowerCase().includes(query);
                var match = matchesCategory && matchesRegion && matchesSize && matchesQuery;
                card.hidden = !match;
                if (match) matches += 1;
            });

            empty.style.display = matches ? 'none' : 'block';
            note.textContent = matches + ' sản phẩm khu công nghiệp · dữ liệu tham khảo từ Khoxuongdep.com.vn';
        }

        tabs.forEach(function (tab) {
            tab.addEventListener('click', function () {
                activeCategory = tab.dataset.kcnCategory;
                tabs.forEach(function (item) { item.classList.toggle('on', item === tab); });
                render();
            });
        });
        keyword.addEventListener('input', render);
        region.addEventListener('change', render);
        size.addEventListener('change', render);
        render();
    }

    function initBds24h() {
        var site = document.querySelector('.bds24h-site');
        if (!site || site.dataset.bdsReady === 'true') return;
        site.dataset.bdsReady = 'true';
        initExistingListing(site);
        initKcnInventory(site);
    }

    function bootBds24h() { window.setTimeout(initBds24h, 0); }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', bootBds24h);
    } else {
        bootBds24h();
    }

    if (window.jQuery) {
        jQuery(window).on('elementor/frontend/init', bootBds24h);
    }
}());
