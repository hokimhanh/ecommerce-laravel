<div id="showModal" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog"
    aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">

        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h3 class="modal-title" id="modalTitle">Product Details</h3>
            </div>
            <div class="modal-body">
                <p>
                    <span><b>Name: </b></span>
                    <span id="fName"></span>
                </p>
                <p>
                    <span><b>Slug: </b></span>
                    <span id="fSlug"></span>
                </p>
                <p>
                    <span><b>Category: </b></span>
                    <span id="fCategory"></span>
                </p>
                <p>
                    <span><b>Price: </b></span>
                    <span>$</span><span id="fPrice"></span>
                </p>
                <p>
                    <span><b>Discount: </b></span>
                    <span id="fDiscount"></span><span>%</span>
                    
                </p>
                <p>
                    <span><b>Status: </b></span>
                    <span id="fStatus"></span>
                </p>
                <p>
                    <span><b>Created at: </b></span>
                    <span id="fCreatedAt"></span>
                    <span><b> Updated at: </b></span>
                    <span id="fUpdatedAt"></span>
                </p>
                <p>
                    <span><b>Images: </b></span>
                <div class="product-images"></div>
                </p>
                <p>
                    <span><b>Description: </b></span>
                    <span id="fDescription"></span>
                    <h6 id="hideShowText" class="text-primary">show / hide</h6>
                </p>

            </div>
        </div>
    </div>
</div>