<style>
    .product-card {
        border: 1px solid #e0e0e0;
        padding: 15px;
        border-radius: 8px;
        display: flex;
        align-items: flex-start;
        margin-bottom: 20px;
    }

    .product-title {
        font-size: 24px;
        margin-bottom: 10px;
    }

    .product-image {
        width: 200px;
        margin-right: 15px;
    }

    .product-content {
        flex: 1;
        margin-bottom: 10px;
    }

    .product-specification {
        margin-bottom: 10px;
    }

    .product-installment-detail {
        margin-bottom: 10px;
    }

    .product-description {
        margin-bottom: 10px;
    }

    @media only screen and (max-width: 480px) {
        .product-card {
            flex-direction: column;
            align-items: center;
        }

        .product-image {
            margin-right: 0;
            width: 250px;
            margin-bottom: 15px;
        }

        .product-content {
            text-align: center;
        }
    }
</style>

<div class="product-card">
    <img src="{{ $image }}" alt="Product Main Image" class="product-image">
    <div class="product-content">
        <div class="product-title">{{ $product->name }}</div>
        <div class="product-specification">{{ $specification }}</div>
        <div class="product-installment-detail">
            共{{ $installment }}期 每期 {{ $installmentPrice }}
        </div>
        <div class="product-description">{{ $product->description }}</div>
    </div>
</div>
