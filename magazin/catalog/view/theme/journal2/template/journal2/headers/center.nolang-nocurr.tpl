<header class="journal-header-center nolang">

    <div class="journal-top-header j-min z-1"></div>
    <div class="journal-menu-bg j-min z-0"> </div>
    <div class="journal-center-bg j-100 z-0"> </div>

    <div id="header" class="journal-header row z-2">

        <div class="journal-links j-min xs-100 sm-100 md-45 lg-45 xl-45">
            <div class="links j-min">
                <div id="top-bar-product-category" class="top-menu-item-1">
                    <div class="heading mobile-trigger">
                        <img src="https://magazin.renania.ro/catalog/view/img/productsmenu-icon-animated.gif">Produse
                        <div class="down-arrow"></div>
                    </div>
                    <ul class="content mobile-menu">
                    <?php foreach ($categories as $category) { ?>
                        <li class="top_bar_product_category_item">
                            <a class="top_bar_product_category_link" href="<?php echo $category['href']; ?>">
                                <span class="top_bar_product_category_link_ikon" style="background-image:url(<?php echo $category['image']; ?>)"></span>
                                <span><?php echo $category['name']; ?></span>
                            </a>
                        </li>
                    <?php } ?>
                    </ul>
                </div>
                <?php if (Front::$IS_OC2): ?>
                <?php echo $search; ?>
                <?php else: ?>
                <div class="search_container top-menu-item-1">
                    <div id="search" class="j-min">
                        <div class="button-search j-min"><i data-icon='&#xe009;'></i></div>
                        <?php if (isset($filter_name)): /* v1541 compatibility */ ?>
                        <?php if ($filter_name) { ?>
                        <input type="text" name="filter_name" value="<?php echo $filter_name; ?>" autocomplete="off" />
                        <?php } else { ?>
                        <input type="text" name="filter_name" value="<?php echo $text_search; ?>" autocomplete="off" onclick="this.value = '';" onkeydown="this.style.color = '#000000';" />
                        <?php } ?>
                        <?php else: ?>
                        <input class="xs-60 sm-60 md-45 lg-45 xl-45" type="text" name="search" placeholder="<?php echo $this->journal2->settings->get('search_placeholder_text'); ?>" value="<?php echo $search; ?>" autocomplete="off" />
                        <?php endif; /* end v1541 compatibility */ ?>
                    </div>
                </div>
                <div class="journal-language" style="display: inline-block;">
                    <?php echo $language; ?>
                </div>
                <?php endif; ?>
                <?php echo $this->journal2->settings->get('config_primary_menu'); ?>
            </div>
        </div>

        <div class="journal-currency j-min xs-5 sm-5 md-10 lg-10 xl-10">
            <?php echo $currency; ?>
        </div>

        <div class="journal-secondary j-min xs-100 sm-100 md-55 lg-55 xl-55">
            <div class="links j-min">
                <?php echo $this->journal2->settings->get('config_secondary_menu'); ?>
                <?php echo $cart; ?>
            </div>
        </div>

        <?php if (!$this->journal2->html_classes->hasClass('mobile') || !$this->journal2->settings->get('responsive_design')): ?>
        <div class="journal-search j-min xs-100 sm-50 md-30 lg-25 xl-25" style="visibility: hidden;">
            <?php if (Front::$IS_OC2): ?>
            <?php echo $search; ?>
            <?php else: ?>
            <div id="search" class="j-min" style="display: none;">
                <div class="button-search j-min"><i data-icon='&#xe009;'></i></div>
                <?php if (isset($filter_name)): /* v1541 compatibility */ ?>
                <?php if ($filter_name) { ?>
                <input type="text" name="filter_name" value="<?php echo $filter_name; ?>" autocomplete="off" />
                <?php } else { ?>
                <input type="text" name="filter_name" value="<?php echo $text_search; ?>" autocomplete="off" onclick="this.value = '';" onkeydown="this.style.color = '#000000';" />
                <?php } ?>
                <?php else: ?>
                <input type="text" name="search" placeholder="<?php echo $this->journal2->settings->get('search_placeholder_text'); ?>" value="<?php echo $search; ?>" autocomplete="off" />
                <?php endif; /* end v1541 compatibility */ ?>
            </div>
            <?php endif; ?>
        </div>
        <div class="journal-logo j-100 xs-100 sm-100 md-40 lg-50 xl-50">
            <?php if ($logo) { ?>
            <div id="logo">
                <a href="<?php echo str_replace($home, 'index.php?route=common/home', ''); ?>">
                    <?php echo Journal2Utils::getLogo($this->config); ?>
                </a>
            </div>
            <?php } ?>
        </div>
        <?php endif; ?>

        <?php if ($this->journal2->html_classes->hasClass('mobile') && $this->journal2->settings->get('responsive_design')): ?>
        <div class="journal-logo j-100 xs-100 sm-100 md-40 lg-50 xl-50">
            <?php if ($logo) { ?>
            <div id="logo">
                <a href="<?php echo $home; ?>">
                    <?php echo Journal2Utils::getLogo($this->config); ?>
                </a>
            </div>
            <?php } ?>
        </div>
        <div class="journal-search j-min xs-100 sm-50 md-30 lg-25 xl-25">
            <?php if (Front::$IS_OC2): ?>
            <?php echo $search; ?>
            <?php else: ?>
            <div id="search" class="j-min">
                <div class="button-search j-min"><i data-icon='&#xe009;'></i></div>
                <?php if (isset($filter_name)): /* v1541 compatibility */ ?>
                <?php if ($filter_name) { ?>
                <input type="text" name="filter_name" value="<?php echo $filter_name; ?>" autocomplete="off" />
                <?php } else { ?>
                <input type="text" name="filter_name" value="<?php echo $text_search; ?>" autocomplete="off" onclick="this.value = '';" onkeydown="this.style.color = '#000000';" />
                <?php } ?>
                <?php else: ?>
                <input type="text" name="search" placeholder="<?php echo $text_search; ?>" value="<?php echo $search; ?>" autocomplete="off" />
                <?php endif; /* end v1541 compatibility */ ?>
            </div>
            <?php endif; ?>
        </div>
        <?php endif; ?>

        <div class="journal-cart row j-min xs-100 sm-50 md-30 lg-25 xl-25">
            <?php //echo $cart; ?>
        </div>

        <div class="journal-menu j-min xs-100 sm-100 md-100 lg-100 xl-100">
            <?php echo $this->journal2->settings->get('config_mega_menu'); ?>
        </div>
        <?php if (!$this->journal2->html_classes->hasClass('mobile') && $this->journal2->settings->get('responsive_design')): ?>
        <script>
            if($(window).width() < 760){
                $('.journal-header-center .journal-logo').after($('.journal-header-center .journal-search'));
            }
        </script>
        <?php endif; ?>
    </div>
</header>