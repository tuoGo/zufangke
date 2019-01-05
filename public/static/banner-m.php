<?php
    $banner_inner_m = '<div class="top-banner">'.
                            '<div class="slide clearfix">'.
                                '<div class="logo">'.
                                    '<img src="static/images/main-banner/logo.png" alt="" width="50" height="40">'.
                                    '<img src="static/images/main-banner/logoFont.png" alt="" width="120" height="40">'.
                                '</div>'.
                            '</div>'.
                      '</div>'.
                      '<div class="left-banner">'.
                            '<div class="user">'.
                                '<img src="static/images/main-banner/user_sm.png" alt="" width="50" height="40">'.
                                '<span class="text">{$Request.session.username}</span>'.
                                '<a href="javascript:void(0)" class="sui-btn btn-large btn-danger">退出</a>'.
                            '</div>'.
                            '<div class="banner-list">'.
                                '<div class="pure-g">'.
                                    '<div class="pure-u-1-1 banner-slide tb">'.
                                        '<span class="text">首页</span>'.
                                    '</div>'.
                                    '<div class="pure-u-1-1 banner-slide wareHouse">'.
                                        '<span class="text">房源管理</span>'.
                                    '</div>'.
                                    '<div class="pure-u-1-1 banner-slide contract">'.
                                        '<span class="text">合同录入</span>'.
                                    '</div>'.
                                    '<div class="pure-u-1-1 banner-slide post">'.
                                        '<span class="text">租金核算</span>'.
                                    '</div>'.
                                    '<div class="pure-u-1-1 banner-slide sleep">'.
                                        '<span class="text">入住确认</span>'.
                                    '</div>'.
                                    '<div class="pure-u-1-1 banner-slide ct_con">'.
                                        '<span class="text">合同续约</span>'.
                                    '</div>'.
                                    '<div class="pure-u-1-1 banner-slide system">'.
                                        '<span class="text">个人中心</span>'.
                                    '</div>'.
                                '</div>'.
                          '</div>'.
                          '<div class="arrow_b ar"></div>'.
                      '</div>'.
                      '<div class="hide-box"></div>';
    echo $banner_inner_m;
