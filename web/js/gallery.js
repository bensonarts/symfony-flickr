(function() {
    var endpoint = '/app_dev.php/api/',
        currentCategory,
        currentImage,
        categoriesArr,
        imagesArr;

    var $title = $('#category-title'),
        $imageList = $('#image-list'),
        $categoryList = $('#category-list'),
        $imageDisplay = $('#image-display');

    /**
     * Start up application. Load categories from API.
     */
    var init = function() {
        $.get(endpoint + 'categories', function(data) {
            buildCategories(data);
        });
    };

    /**
     * Build category items into the DOM.
     *
     * @param Array categories
     */
    var buildCategories = function(categories) {
        categoriesArr = categories;
        $.each(categories, function(index, value) {
            $categoryList.append(createCategoryLink(value));
        });
    };

    /**
     * Build image thumbnails into the DOM.
     *
     * @param Array images
     */
    var buildImages = function(images) {
        $.each(images, function(index, value) {
            $imageList.append(createImageLink(value));
        });
    };

    /**
     * Generate markup for thumbnail image.
     *
     * @param Object image
     * @return string
     */
    var createImageLink = function(image) {
        return '<div class="col-xs-3 col-md-3"><a class="thumbnail" href="#" data-attr="' + image.id + '"><img src="' + image.thumbnail_url + '" alt="' + image.title + '"></a></div>';
    };

    /**
     * Retrieve image list from the selected category.
     */
    var getImages = function() {
        showImageLoader();
        $.get(endpoint + 'categories/' + currentCategory.id, function(data) {
            if (data.images && data.images.length) {
                imagesArr = data.images;
                clearImageList();
                buildImages(data.images);
            } else {
                $imageList.html('<p>No images found.</p>');
            }
        });
    };

    /**
     * Create markup for the category link.
     *
     * @param Object category
     * @return string
     */
    var createCategoryLink = function(category) {
        return '<li role="presentation"><a href="#" data-attr="' + category.id + '">' + category.name + '</a></li>';
    }

    /**
     * Load category data based on selection.
     *
     * @param Integer categoryId
     */
    var loadCategory = function(categoryId) {
        $.each(categoriesArr, function(index, value) {
            if (value.id == categoryId) {
                currentCategory = value;
                return false;
            }
        });

        if (currentCategory) {
            $title.html(currentCategory.name + ' Photo Gallery');
            getImages();
        }
    };

    /**
     * Load large image based on thumbnail selection.
     *
     * @param Integer imageId
     */
    var loadImage = function(imageId) {
        $.each(imagesArr, function(index, value) {
            if (value.id == imageId) {
                currentImage = value;
                return false;
            }
        });

        if (currentImage) {
            $imageList.hide();
            $imageDisplay.show().html('<div class="panel panel-default">' +
                    '<div class="panel-body">' +
                        '<div class="row">' +
                            '<div class="col-md-8">' +
                                '<img src="' + currentImage.url + '" class="img-responsive" alt="' + currentImage.title + '">' +
                            '</div>' +
                            '<div class="col-md-4">' +
                                '<button type="button" id="back" class="btn btn-default pull-right" aria-label="Back">' +
                                    '<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>' +
                                '</button>' +
                                '<h3>' + currentImage.title + '</h3>' +
                                '<p>' + currentImage.description + '</p>' +
                            '</div>' +
                        '</div>' +
                    '</div>' +
                '</div>');
        }
    };

    /**
     * Display preloader for AJAX images call.
     */
    var showImageLoader = function() {
        $imageList.html('<div class="progress">' +
            '<div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">' +
                '<span class="sr-only">100% Complete</span>' +
                '</div>' +
            '</div>');
    };

    /**
     * Hide enlarged image display.
     */
    var hideImageDisplay = function() {
        $imageDisplay.hide().html('');
        $imageList.show();
    }

    /**
     * Clear the image list view.
     */
    var clearImageList = function() {
        $imageList.html('');
    };

    /**
     * Handler for category link clicks.
     */
    $categoryList.on('click', 'li > a', function() {
        $('#category-list li').removeClass('active');
        var id = $(this).attr('data-attr');
        $(this).parent().addClass('active');
        loadCategory(id);
    });

    /**
     * Handler for thumbnail clicks.
     */
    $imageList.on('click', 'a.thumbnail', function() {
        var id = $(this).attr('data-attr');
        loadImage(id);
    });

    $imageDisplay.on('click', 'button#back', function() {
        hideImageDisplay();
    });

    init();
}());
