<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Admin Dashboard</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f5f6f8;
            margin: 0;
            padding: 0;
            color: #111827;
        }

        .admin-wrap {
            max-width: 1100px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .admin-header {
            margin-bottom: 28px;
        }

        .admin-header h1 {
            margin: 0 0 8px;
            font-size: 32px;
        }

        .admin-header p {
            margin: 0;
            color: #6b7280;
        }

        .admin-menu-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 18px;
        }

        .admin-menu-card {
            display: block;
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 22px;
            text-decoration: none;
            color: #111827;
            box-shadow: 0 3px 10px rgba(0,0,0,0.05);
            transition: 0.2s ease;
        }

        .admin-menu-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.08);
            border-color: #3166f6;
        }

        .admin-menu-icon {
            font-size: 30px;
            margin-bottom: 12px;
        }

        .admin-menu-card h3 {
            margin: 0 0 8px;
            font-size: 18px;
        }

        .admin-menu-card p {
            margin: 0;
            color: #6b7280;
            font-size: 14px;
            line-height: 1.5;
        }

        @media (max-width: 900px) {
            .admin-menu-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 560px) {
            .admin-menu-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>

<div class="admin-wrap">

    <div class="admin-header">
        <h1>Admin Dashboard</h1>
        <p>จัดการข้อมูลสินค้า ตัวเลือก ราคา และหน้าบ้าน</p>
    </div>

    <div class="admin-menu-grid">

        <a href="{{ route('admin.products.index') }}" class="admin-menu-card">
            <div class="admin-menu-icon">📦</div>
            <h3>Products</h3>
            <p>เพิ่ม แก้ไข ลบสินค้า และจัดการข้อมูลหลักของสินค้า</p>
        </a>

        <a href="{{ route('admin.product-details.index') }}" class="admin-menu-card">
            <div class="admin-menu-icon">📝</div>
            <h3>Product Details</h3>
            <p>จัดการรายละเอียดสินค้า รูป sample, specification, accordion</p>
        </a>

        <a href="{{ route('admin.product-price-tiers.index') }}" class="admin-menu-card">
            <div class="admin-menu-icon">💰</div>
            <h3>Product Price Tiers</h3>
            <p>จัดการราคาขั้นบันไดตามจำนวนสินค้า</p>
        </a>

        <a href="{{ route('admin.option-groups.index') }}" class="admin-menu-card">
            <div class="admin-menu-icon">🧩</div>
            <h3>Option Groups</h3>
            <p>จัดการหัวข้อ option เช่น สี ขนาด รูปแบบสาย และ display type</p>
        </a>

        <a href="{{ route('admin.product-options.index') }}" class="admin-menu-card">
            <div class="admin-menu-icon">✅</div>
            <h3>Product Options</h3>
            <p>จัดการตัวเลือกย่อย รูปภาพ สี ราคาเพิ่ม และ variants</p>
        </a>

        <a href="{{ route('admin.option-dependencies.index') }}" class="admin-menu-card">
            <div class="admin-menu-icon">🔗</div>
            <h3>Option Dependencies</h3>
            <p>กำหนดความสัมพันธ์ของ option เช่น เลือก A แล้วแสดง B</p>
        </a>

        <a href="{{ route('admin.categories.index') }}" class="admin-menu-card">
            <div class="admin-menu-icon">📁</div>
            <h3>Categories</h3>
            <p>จัดการหมวดหมู่สินค้าและรูปหมวดหมู่</p>
        </a>

        <a href="{{ route('admin.materials.index') }}" class="admin-menu-card">
            <div class="admin-menu-icon">🧵</div>
            <h3>Materials</h3>
            <p>จัดการวัสดุสินค้า เช่น Polyester, Nylon, PVC</p>
        </a>

        <a href="{{ route('admin.product-list-banners.index') }}" class="admin-menu-card">
            <div class="admin-menu-icon">🖼️</div>
            <h3>Product List Banners</h3>
            <p>จัดการ banner หน้า product list / carousel</p>
        </a>

    </div>

</div>

</body>
</html>