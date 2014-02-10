/*****************************************************************
 * @class CMS
 * @copyright Copyright (c) 2010-Present, 061375
 * @author Jeremy Heminger <j.heminger@061375.com>
 * @bindings : jQuery
 * @deprecated = false
 *
 * */
var CMS = {
    private: {},
    /**
     * Handles the Ajax calls of the class
     * @method getData
     * @param {String} method : the method in PHP 
     * @param {Object} params : arguments ( equivilent to GET )
     * */
    getData: function(method,params,data) {
        $this = this;
        post = {
            // this comes from PHP -> SESSION ( set on login )
            // random hash that must be compared to what is in the database
            confirmation_key : $this.private.confirmation_key,
            data : data
        }
        // build the url 
	var url = $this.private.base_url + $this.private.ajax_path + method;
        if (undefined !== params) {
            $.each (params,function(k,v) {
                url += "/" + v;  
            });
        }
        $.logThis('send ajax');
        // run the AJAX
	return $.ajax({
            url      : url,
            data     : post,
            type     : "post",
            dataType : "json"
	});
    },
    /**
     * Gets a list of ALL articles 
     * @method getArticles
     * @param {Object} $target : the DOM element to put the HTML inside 
     * @param {Object} params : arguments ( equivilent to GET )
     * */
    getArticles: function($target,params) {
        $.logThis('getArticles');
        var post = {
            start_date : $('#start_date').html(),
            end_date : $('#end_date').html()
        }
        var promise = this.getData('listArticles',params,post);
        this.displayArticles(promise,$target);    
    },
    /**
     * Displays the articles in a table
     * @method displayArticles
     * @param {Object} p : a promise to the AJAX object to display the result when it is ready 
     * @param {Object} $target : the DOM element to appent the result to
     * */
    displayArticles: function(p,$target) {
        var $this = this;
        p.success( function(data) {
            if (data.success == 1) {
                $target.html(data.data);
                // initializes jQuery.UI dynamic data table
                $this.initDataTable($('#articles'));
                $target.fadeIn("fast");
            } else if (data.logout == 1) {
                // logout users who have timed out on server
                this.logOut();   
            } else {
                // display error in console
                $.logThis(data.error);
            }
        });
    },
    /**
     * Gets article sections
     * @method getArticleSections
     * @param {Object} $target : the DOM element to put the HTML inside 
     * @param {Object} params : arguments ( equivilent to GET )
     * */
    getArticleSections: function($target,params) {
        $.logThis('getArticles');
        var promise = this.getData('listSections',params);
        this.displayArticleSections(promise,$target);       
    },
    /**
     * Displays sections in a <select> tag
     * @method displayArticleSections
     * @param {Object} p : a promise to the AJAX object to display the result when it is ready 
     * @param {Object} $target : the DOM element to appent the result to
     * */
    displayArticleSections: function(p,$target) {
        var $this = this;
        p.success( function(data) {
            if (data.success == 1) {
                $target.html('');
                var option = document.createElement("option");
                $(option).attr("value", "");
                $(option).html("-- Select One --");
                $target.append(option);
                $.each(data.data,function(k,v){
                    var option = document.createElement("option");
                    $(option).attr("value", v.id);
                    $(option).html(v.section);
                    $target.append(option);
                });
            } else if (data.logout == 1) {
                // logout users who have timed out on server
                this.logOut();   
            } else {
                // display error in console
                $.logThis(data.error);
            }
        });
    },
    /**
     * Saves a new article
     * @method saveArticle
     * @param {Object} $target : the DOM element to put the HTML inside 
     * @param {Object} params : arguments ( equivilent to GET )
     * */
    saveArticle: function($target,params) {
        $.logThis('saveArticle');
        var error = false;
        var data = {
            title : $('#article_title').val(),
            section_id : $('#article_section').val(),
            post : tinyMCE.activeEditor.getContent({format : 'raw'})
        };
        // catch user errors
        if ( data.title == '' ) {
            error = "Please give your article a title.";
        }
        if ( data.section_id == '' ) {
            error = "Please select an article section.";
        }
        if ( error === false ) {
            var promise = this.getData('addNewArticle',params,data);
            this.saveArticleResult(promise,$target);
        } else {
            alert(error);
        }
    },
    /**
     * Displays the result of saving a new article
     * @method saveArticleResult
     * @param {Object} p : a promise to the AJAX object to display the result when it is ready 
     * @param {Object} $target : the DOM element to appent the result to
     * */
    saveArticleResult: function(p,$target) {
        var $this = this;
        p.success( function(data) {
            if (data.success == 1) {
                CMS.getArticles($('#articles_container'));
                alert("New article added succesfully");
            } else if (data.logout == 1) {
                // logout users who have timed out on server
                this.logOut();   
            } else {
                // display error in console
                $.logThis(data.error);
            }
        });    
    },
    /**
     * Loads a single article by ID
     * @method loadSingleArticle
     * @param {Object} $target : the DOM element to put the HTML inside 
     * @param {Object} params : arguments ( equivilent to GET )
     * */
    loadSingleArticle: function($target,params) {
        var promise = this.getData('getArticleByID',params);
        this.displaySingleArticle(promise,$target);
    },
    /**
     * Displays the result of loading a single article
     * @method displaySingleArticle
     * @param {Object} p : a promise to the AJAX object to display the result when it is ready 
     * @param {Object} $target : the DOM element to appent the result to
     * */
    displaySingleArticle: function(p,$target) {
        var $this = this;
        p.success( function(data) {
            if (data.success == 1) {
                tinyMCE.activeEditor.setContent(data.data.article);
                $('#article_title').val(data.data.title);
                $('#article_section').val(data.data.section_id);
                CMS.fadeSection('article_edit_button');
            } else if (data.logout == 1) {
                // logout users who have timed out on server
                this.logOut();   
            } else {
                // display error in console
                $.logThis(data.error);
            }
        });   
    },
    /**
     * Delete article(s) by ID
     * @method deleteArticles
     * @param {Object} $target : the DOM element to put the HTML inside 
     * @param {Object} params : arguments ( equivilent to GET )
     * */
    deleteArticles: function($target,params) {
        var promise = this.getData('deleteArticlesByID',params,data);
        this.displaySingleArticle(promise,$target);   
    },
    /**
     * Displays the result of deleteing articles
     * @method deleteArticleResult
     * @param {Object} p : a promise to the AJAX object to display the result when it is ready 
     * @param {Object} $target : the DOM element to appent the result to
     * */
    deleteArticleResult: function(p,$target) {
        var $this = this;
        p.success( function(data) {
            if (data.success == 1) {
                alert("Article(s) deleted succesfully");
                CMS.getArticles($('#articles_container'));
            } else if (data.logout == 1) {
                // logout users who have timed out on server
                this.logOut();   
            } else {
                // display error in console
                $.logThis(data.error);
            }
        });   
    },
    /**
     * Fades out all section related to target then fades in specific target id
     * @method fadeSection
     * @param {String} id : delimitted by '_' format [target]_[action]_[type]
     * */
    fadeSection: function(id) {
        variables = id.split("_");
        var target_id = '#'+variables[0]+'_'+variables[1];
        var target_classes = '.'+variables[0]+'_section';
        $(target_classes).each(function(){
           $(this).fadeOut("fast"); 
        });
        $(target_id).fadeIn("fast");  
    },
    /**
     * Sets up and run jQuery UI Datatable
     * @method initDataTable
     * @param {Object} $target : "table" to act on
     * */
    initDataTable: function($target) {
        $target.dataTable({
                "aaSorting": [[ 3, "desc" ]],
                aoColumnDefs: [
                               { "aTargets": [ 0 ], "bSortable": false },
                               { "aTargets": [ 5 ], "bSortable": false },
                               { "aTargets": [ 6 ], "bSortable": false }
                ]
        });   
    },
    /**
     * Redirects user to logout URL
     * @method logOut
     * */
    logOut: function() {
        window.location = $('#base_url').html()+'profile/logout';
    }
}
/**
 *  Initialize
 *  */
$(document).ready(function() {
    // console.log if it exists ( protect old browsers )
    jQuery.logThis = function( text ){
        if( (window['console'] !== undefined) ){
            console.log( text );
        }
    }
    // force the user to logout after X unless user interaction
    var logout_id = window.setInterval(function(){CMS.logOut()}, 10000000);
    // if the user clicks something "reset the timer"
    $('body').on("click",function(){
        window.clearInterval(logout_id);
        logout_id = window.setInterval(function(){CMS.logOut()}, 10000000);
    });
    // binds buttons to allow navigation within a section
    $('.nav_button').on("click",function(){
        var id = $(this).attr("id");
        CMS.fadeSection(id);
    });
    $('#articles_container').on("click",'.edit_article_button',function(){
        var params = {id : $(this).attr("id")};
        CMS.loadSingleArticle($(this),params);
    });
    $('#articles_container').on("click",'#delete_articles_button',function(){
        if (false != confirm("Are you sure you want to delete the selected articles?")) {
            var id_list = [];
            $('.delete_articles_checkbox').each(function(){
                console.log($(this).prop('checked'));
                if (true == $(this).prop('checked') ){
                    id_list.push($(this).attr("id"));
                }
            });
            if (id_list.length == 0) {
                alert("No articles selected for deletion.");
            } else {
                console.log(id_list);
            }
            
        }
    });
    // initialize CMS private variables
    CMS.private = {
        base_url : $('#base_url').html(),
        path : 'cms',
        ajax_path : 'ajax/cms/',
        confirmation_key : $('#confirmation_key').html()
    };
    // load article sections
    CMS.getArticleSections($('#article_section'));
});