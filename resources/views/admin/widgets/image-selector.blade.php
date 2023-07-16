<?php

/** @var $title */

?>


<div class="image-selector form-group">
    <label for="control-label"><?= $title ?></label>
    <div class="image-selector__open" style="cursor: pointer; display: flex">
        <div class="image-selector__value"
             style="width: 100%;min-height:140px;max-height:220px;"></div>
    </div>

    <div class="modal-win" style="background: white;background:rgba(255, 255, 255, 0.9);display: none">
        <div class="modal-dialog">
            <div class="modal-header">
                <div class="modal-title">Choose a picture</div>
            </div>
            <div class="modal-content">
                <a class="image-selector__cancel">Отмена</a>
                <input name="page" type="number" min="1" value="1">
                <div class="ajax-data"  style="overflow-y: scroll; height: 300px; padding: 5px">

                </div>
            </div>
        </div>
    </div>
</div>


<script
    src="https://code.jquery.com/jquery-3.7.0.slim.js"
    integrity="sha256-7GO+jepT9gJe9LB4XFf8snVOjX3iYNb0FHYr5LI1N5c="
    crossorigin="anonymous"></script>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        class ImageSelector {
            constructor(el) {
                this.el = el
                this.control = $('.image-selector__open', el)
                this.modal = $('.modal-win', el)
                this.imageList = $('.ajax-data', el)
                this.value = $('.image-selector__value', el)
                this.cancel = $('.image-selector__cancel', el)
                this.page = $('input[name="page"]', this.el)

                this.control.click(() => {
                    this.open()
                    this.refreshImageList()
                    return false;
                })

                this.cancel.click(() => {
                    this.close()
                })

                this.page.change(() => {
                    this.refreshImageList()
                })
            }

            refreshImageList() {
                $.ajax({
                    method: 'post', 'url': '/admin/ajax',
                    data: { component: '\\App\\Widgets\\Admin\\ImageSelector', command: 'content',
                        params: { page: this.page.val()} }
                }).then((data) => {
                    console.log(data)
                    this.imageList.html(data.content)
                    this.images = $('.image-selector__image', this.el)

                    this.images.find('span').click((el) => {
                        this.setValue($(el.currentTarget))
                        this.close();
                    })
                })
            }

            setValue(el) {
                this.value.css('background-image', `url(${el.parent().find('img').attr('src').replace('thumbs', 'photos')})`)

                $.ajax({
                    method: 'post', 'url': '/admin/ajax',
                    data: { component: '\\App\\Widgets\\Admin\\ImageSelector', command: 'setValue', params: {id: el.attr('data-id')} }
                }).then((data) => {
                    console.log(data)
                })
            }

            open() {
                this.modal.show()
            }

            close() {
                this.modal.hide()
            }
        }

        imageList = new ImageSelector($('.image-selector'))
    })
</script>

<style>
    .image-selector {
        border: 1px solid #000;
    }
    .image-selector__value {
        margin: 5px;
    }
    .image-selector__image {
        cursor: pointer;
    }
    .image-selector__image:hover {
        background: #eee;
    }
</style>
