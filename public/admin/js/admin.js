$(document).ready(function() {
    $('body').on('click', '.editthuonghieu', function() {
        var mahang = $(this).data('mahangedit');
        var href = '/findOneth/?id=' + mahang;
        $.get(href, function(thuonghieu, status) {
            $('.myform #maHang').val(thuonghieu.maHang);
            $('.myform #tenHang').val(thuonghieu.tenHang);
            $(".myform input[type='file']").val(thuonghieu.logo);
        });

    });

    $('#addthuonghieu').click(function(event) {
        if ($('#tenhangadd').val() == false || $('#fileupload').val() == false) {
            alert(" Không được để chống các trường có ký hiệu * ! ");
        } else {
            $.ajax({
                url: "http://localhost:9999/saveth",
                type: "GET",
                data: {
                    maHang: $('#mahangadd').val(),
                    tenHang: $('#tenhangadd').val(),
                    logo: $('#fileupload').val()
                },
                success: function(value) {
                    alert(value);
                    window.location = " http://localhost:9999/admin/thuonghieu";
                },
                error: function(e) {
                    alert(" ERROR! ");
                    console.log(" ERROR: ", e);
                }
            });
        }
    });

    $('#editthuonghieu').click(function(event) {
        if ($('#tenhangadd').val() == false || $('#fileupload').val() == false) {
            alert(" Không được để chống các trường có ký hiệu * ! ");
        } else {
            $.ajax({
                url: "http://localhost:9999/updateth",
                type: "GET",
                data: {
                    maHang: $('#maHang').val(),
                    tenHang: $('#tenHang').val(),
                    logo: $('#logo').val()
                },
                success: function(value) {
                    alert(value);
                    window.location = " http://localhost:9999/admin/thuonghieu";
                },
                error: function(e) {
                    alert(" ERROR! ");

                }
            });
        }
    });

    $('body').on('click', '.editsize', function() {
        var masize = $(this).data('masizeedit');
        var href = '/findOnesize/?id=' + masize;
        $.get(href, function(size, status) {
            $('.myform #maSize').val(size.maSize);
            $('.myform #tenSize').val(size.tenSize);
        });

    });

    $('#addsize').click(function(event) {
        if ($('#tensizeadd').val() == false) {
            alert(" Không được để chống các trường có ký hiệu * ! ");
        } else {
            $.ajax({
                url: "http://localhost:9999/savesize",
                type: "GET",
                data: {
                    maSize: $('#masizeadd').val(),
                    tenSize: $('#tensizeadd').val(),
                },
                success: function(value) {
                    alert(value);
                    window.location = " http://localhost:9999/admin/size";
                },
                error: function(e) {
                    alert(" ADD KHÔNG ĐƯỢC : TÊN SIZE GIỐNG NHAU!! ");
                }
            });
        }
    });
    $('#editsize').click(function(event) {
        if ($('#tensize').val() == false) {
            alert(" Không được để chống các trường có ký hiệu * ! ");
        } else {
            $.ajax({
                url: "http://localhost:9999/updatesize",
                type: "GET",
                data: {
                    maSize: $('#maSize').val(),
                    tenSize: $('#tenSize').val(),
                },
                success: function(value) {
                    alert(value);
                    window.location = " http://localhost:9999/admin/size";
                },
                error: function(e) {
                    alert(" EDIT KHÔNG ĐƯỢC : TÊN SIZE GIỐNG NHAU! ");
                }
            });
        }
    });

    $('#addgroupproduct').click(function(event) {

        console.log("trung ", $('#name').val());
        if ($('#name').val() == false) {
            alert(" Không được để chống các trường có ký hiệu * ! ");
        } else {
            $.ajax({
                url: "http://localhost:9999/savespsize",
                type: "GET",
                data: {
                    maSP: $('#maspadd').val(),
                    maSize: $('#masizeadd').val(),
                    soluong: $('#soluongadd').val(),
                },
                success: function(value) {
                    alert(value);
                    window.location = " http://localhost:9999/admin/sanphamsize";
                },
                error: function(e) {
                    alert(" ĐÃ CÓ SIZE NÀY THUỘC SẢN PHẨM  ");
                }
            });
        }
    });

    $('body').on('click', '.editloaisp', function() {
        var maloaisp = $(this).data('maloaispedit');
        var href = '/findOneloaisp/?id=' + maloaisp;
        $.get(href, function(loaisanpham, status) {
            $('.myform #maLoaiSP').val(loaisanpham.maLoaiSP);
            $('.myform #tenLoaiSP').val(loaisanpham.tenLoaiSP);
        });
    });

    $('#addloaisp').click(function(event) {
        if ($('#maloaispadd').val() == false || $('#tenloaispadd').val() == false) {
            alert(" Không được để chống các trường có ký hiệu * ! ");
        } else {
            $.ajax({
                url: "http://localhost:9999/saveloaisp",
                type: "GET",
                data: {
                    maLoaiSP: $('#maloaispadd').val(),
                    tenLoaiSP: $('#tenloaispadd').val(),
                },
                success: function(value) {
                    alert(value);
                    window.location = " http://localhost:9999/loaisanpham";
                },
                error: function(e) {
                    alert(" ERROR!  ");
                }
            });
        }
    });

    $('#editloaisp').click(function(event) {
        if ($('#maLoaiSP').val() == false || $('#tenLoaiSP').val() == false) {
            alert(" Không được để chống các trường có ký hiệu * ! ");
        } else {
            $.ajax({
                url: "http://localhost:9999/updateloaisp",
                type: "GET",
                data: {
                    maLoaiSP: $('#maLoaiSP').val(),
                    tenLoaiSP: $('#tenLoaiSP').val(),
                },
                success: function(value) {
                    alert(value);
                    window.location = " http://localhost:9999/loaisanpham";
                },
                error: function(e) {
                    alert(" ĐÃ CÓ SIZE NÀY THUỘC SẢN PHẨM ");
                }
            });
        }
    });
    $('body').on('click', '.editkm', function() {
        var makm = $(this).data('makmedit');
        var href = '/findOnekm/?id=' + makm;
        $.get(href, function(khuyenmai, status) {
            $('.myform #makm').val(khuyenmai.maKM);
            $('.myform #tenkm').val(khuyenmai.tenKM);
            $('.myform #giakm').val(khuyenmai.giaKM);
            $('.myform #ngaybd').val(khuyenmai.ngayBD);
            $('.myform #ngaykt').val(khuyenmai.ngayKT);
            if (khuyenmai.type == true) {
                $('.myform #type').val(1);
            } else {
                $('.myform #type').val(2);
            }
            $('.myform #mota').val(khuyenmai.moTa);
            $('.myform #anh').val(khuyenmai.image);
        });
    });
    $('#addkm').click(function(event) {
        if ($('#makmadd').val() == false || $('#tenkmadd').val() == false || $('#giakmadd').val() == false ||
            $('#ngaybdadd').val() == false || $('#ngayktadd').val() == false || $('#motaadd').val() == false ||
            $('#anhadd').val() == false || $('#typeadd').val() == false) {
            alert(" Không được để chống các trường có ký hiệu * ! ");
        } else {
            $.ajax({
                url: "http://localhost:9999/savekm",
                type: "GET",
                data: {
                    maKM: $('#makmadd').val(),
                    tenKM: $('#tenkmadd').val(),
                    giaKM: $('#giakmadd').val(),
                    ngayBD: $('#ngaybdadd').val(),
                    ngaykt: $('#ngayktadd').val(),
                    moTa: $('#motaadd').val(),
                    image: $('#anhadd').val(),
                    type: $('#typeadd').val(),
                },
                success: function(value) {
                    alert(value);
                    window.location = " http://localhost:9999/khuyenmai";
                },
                error: function(e) {
                    alert(" kiểm tra ngày bắt đầu phải trước ngày hiện tại ! kiểm tra ngày kết thúc trước ngày bắt đầu! ");
                }
            });
        }
    });

    $('#editkhuyenmai').click(function(event) {
        if ($('#makm').val() == false || $('#tenkm').val() == false || $('#giakm').val() == false ||
            $('#ngaybd').val() == false || $('#ngaykt').val() == false || $('#mota').val() == false ||
            $('#anh').val() == false || $('#type').val() == false) {
            alert(" Không được để chống các trường có ký hiệu * ! ");
        } else {
            $.ajax({
                url: "http://localhost:9999/updatekm",
                type: "GET",
                data: {
                    maKM: $('#makm').val(),
                    tenKM: $('#tenkm').val(),
                    giaKM: $('#giakm').val(),
                    ngayBD: $('#ngaybd').val(),
                    ngaykt: $('#ngaykt').val(),
                    moTa: $('#mota').val(),
                    image: $('#anh').val(),
                    type: $('#type').val(),
                },
                success: function(value) {
                    alert(value);
                    window.location = " http://localhost:9999/khuyenmai";
                },
                error: function(e) {
                    alert(" kiểm tra ngày bắt đầu phải trước ngày hiện tại ! kiểm tra ngày kết thúc trước ngày bắt đầu ! ");
                }
            });
        }
    });

    $('.editcthoadon').on('click', function(event) {
        event.preventDefault();
        var href = $(this).attr('href');
        $.get(href, function(chitiethoadon, status) {
            $('.myform #tensp').val(chitiethoadon.tenSP);
            $('.myform #tensize').val(chitiethoadon.tenSize);
            $('.myform #soluong').val(chitiethoadon.soluong);
            $('.myform #giatri').val(chitiethoadon.giatri);
            $('.myform #dongia').val(chitiethoadon.donGia);
            $('.myform #diachi').val(chitiethoadon.diachi);
            $('.myform #mota').val(chitiethoadon.moTa);
            if (chitiethoadon.trangthai == 1) {
                $('.myform #type').val("Thành Công");
            }
            if (chitiethoadon.trangthai == 0) {
                $('.myform #type').val("Chờ Duyệt");
            }
            if (chitiethoadon.trangthai == 2) {
                $('.myform #type').val(" Không Thành Công ");
            }
            $('.myform #ngaylap').val(chitiethoadon.ngaylap);
            $('.myform #nguoinhan').val(chitiethoadon.nguoinhan);
            $('.myform #sdt').val(chitiethoadon.sdt);
        });
    });

    $('body').on('click', '.editsanpham', function() {
        var masp = $(this).data('maspedit');
        var href = '/findOnesp/?id=' + masp;
        $.get(href, function(sanpham, status) {
            $('.myform #masp').val(sanpham.maSP);
            $('.myform #mahang').val(sanpham.maHang);
            $('.myform #makm').val(sanpham.maKM);
            $('.myform #maloaisp').val(sanpham.maLoaiSP);
            $('.myform #tensp').val(sanpham.tenSP);
            $('.myform #mota').val(sanpham.moTa);
            $('.myform #dongia').val(sanpham.donGia);
            $('.myform #hinhanh').val(sanpham.image);
        });
    });

    $('#addsanpham').click(function(event) {
        if ($('#maspadd').val() == false || $('#mahangadd').val() == false || $('#maloaispadd').val() == false ||
            $('#tenspadd').val() == false || $('#dongiaadd').val() == false || $('#hinhanhadd').val() == false) {
            alert(" Không được để chống các trường có ký hiệu * ! ");
        } else {
            $.ajax({
                url: "http://localhost:9999/savesp",
                type: "GET",
                data: {
                    maSP: $('#maspadd').val(),
                    maHang: $('#mahangadd').val(),
                    maKM: $('#makmadd').val(),
                    maLoaiSp: $('#maloaispadd').val(),
                    tenSP: $('#tenspadd').val(),
                    donGia: $('#dongiaadd').val(),
                    manHinh: $('#hinhanhadd').val(),
                    moTa: $('#motaadd').val(),
                },
                success: function(value) {
                    alert(value);
                    window.location = " http://localhost:9999/sanpham";
                },
                error: function(e) {
                    alert(" ERROR! ");
                }
            });
        }
    });

    $('#editsanpham').click(function(event) {
        if ($('#masp').val() == false || $('#mahang').val() == false || $('#maloaisp').val() == false ||
            $('#tensp').val() == false || $('#dongia').val() == false || $('#hinhanh').val() == false) {
            alert(" Không được để chống các trường có ký hiệu * ! ");
        } else {
            $.ajax({
                url: "http://localhost:9999/updatesp",
                type: "GET",
                data: {
                    maSP: $('#masp').val(),
                    maHang: $('#mahang').val(),
                    maKM: $('#makm').val(),
                    maLoaiSp: $('#maloaisp').val(),
                    tenSP: $('#tensp').val(),
                    donGia: $('#dongia').val(),
                    manHinh: $('#hinhanh').val(),
                    moTa: $('#mota').val(),
                },
                success: function(value) {
                    alert(value);
                    window.location = " http://localhost:9999/sanpham";
                },
                error: function(e) {
                    alert(" ERROR! ");
                }
            });
        }
    });

    $(".checkboxall").on('click', function(event) {
        var inputElements = document.getElementsByName('post[]');
        var ischeck = $(this).is(":checked");
        for (var i = 0; i < inputElements.length; i++) {

            inputElements[i].checked = ischeck;
        }
    });

    $(".checkone").on('click', function(event) {
        var ischeck = document.getElementsByName('post[]').length === $('input[name="post[]"]:checked').length;
        document.getElementsByName('checkboxall').checked = ischeck;

    });

    $("#apply").click(function(event) {
        var cboxes = document.getElementsByName('post[]');
        var inputElements = document.getElementsByClassName('checkone');
        var arr = [];
        for (var i = 0; i < cboxes.length; i++) {
            if (cboxes[i].checked == true) {
                var val = inputElements[i].value;
                arr.push(val);
            }
        }
        if ($('input[name="post[]"]:checked').length > 0) {
            $.ajax({
                url: "http://localhost:9999/savedh",
                type: "GET",
                data: {
                    key: $("#trangthai").val(),
                    list: JSON.stringify(arr),
                },
                success: function(value) {
                    alert(value);
                    window.location = " http://localhost:9999/admin/donhang";
                },
                error: function(e) {
                    alert(" ERROR! ");
                }
            });
        } else {
            alert("Chưa chọn đơn hàng nào !");
        }
    });

    $("#duyet").click(function(event) {
        var arr = [];
        var a = $("#checkone").val();
        arr.push(a);
        $.ajax({
            url: "http://localhost:9999/savedh",
            type: "GET",
            data: {
                key: 1,
                list: JSON.stringify(arr),
            },
            success: function(value) {
                alert(value);
                window.location = " http://localhost:9999/admin/donhang";
            },
            error: function(e) {
                alert(" ERROR! ");
            }
        });
    });

    $("#noduyet").click(function(event) {
        var arr = [];
        var a = $("#checkone").val();
        arr.push(a);
        $.ajax({
            url: "http://localhost:9999/savedh",
            type: "GET",
            data: {
                key: 2,
                list: JSON.stringify(arr),
            },
            success: function(value) {
                alert(value);
                window.location = " http://localhost:9999/admin/donhang";
            },
            error: function(e) {
                alert("ERROR !");
            }
        });
    });

    $("#file").change(function() {
        var files = $("#file")[0].files;

        if (files.length > 5) {
            alert("Bạn chọn tối đa chỉ được 5 ảnh ");
            $("#file").val("");
            return false;
        } else if (files.length === 0) {
            alert("Bạn không được để chống ");
            $("#file").val("");
            return false;
        } else if (files.size > 2000000) {
            alert("file ảnh không được lớn hơn 2MB ");
            $("#file").val("");
            return false;
        }
    });


    $("#load").click(function(event) {
        var arr = [];
        var fi = document.getElementById('file');
        for (var i = 0; i < fi.files.length; i++) {
            var a = fi.files.item(i).name;
            arr.push(a);
        }
        var masp = $('#id__sp').val();
        $.ajax({
            url: "http://localhost:9999/saveha",
            type: "GET",
            data: {
                id: $('#id__sp').val(),
                list: JSON.stringify(arr),
            },
            success: function(value) {
                alert(value);
                window.location = " http://localhost:9999/hinhanh?id=" + masp;
            },
            error: function(e) {
                alert(" ERROR! ");
            }
        });
    });

    $('#addnguoidung').click(function(event) {
        if ($('#nameadd').val() == false || $('#sdtadd').val() == false || $('#emailadd').val() == false || $('#passadd').val() == false || $('#statusadd').val() == false || $('#quyenadd').val() == false) {
            alert(" Không được để trống các trường có ký hiệu * ! ");
        } else {
            $.ajax({
                url: "http://localhost:9999/savend",
                type: "GET",
                data: {
                    hoten: $('#nameadd').val(),
                    sdt: $('#sdtadd').val(),
                    email: $('#emailadd').val(),
                    mk: $('#passadd').val(),
                    status: $('#statusadd').val(),
                    quyen: $('#quyenadd').val()
                },
                success: function(data) {
                    alert(data);
                    window.location = " http://localhost:9999/nguoidung";
                },
                error: function(e) {
                    alert(" nhập email không chính xác theo định dạng @gmail.com hoặc đã có email đăng ký ! ");

                }
            });

        }
    });

    $('body').on('click', '.editnguoidung', function() {
        var id = $(this).data('idedit');
        var href = '/findOnend/?id=' + id;
        $.get(href, function(nguoidung, status) {
            $('.myform #nameedit').val(nguoidung.hoten);
            $('.myform #sdtedit').val(nguoidung.sdt);
            $(".myform #emailedit").val(nguoidung.email);
            $(".myform #statusedit").val(nguoidung.Status);
            $(".myform #quyenedit").val(nguoidung.quyen);
        });

    });

    $('#editnguoidung').click(function(event) {
        if ($('#nameedit').val() == false || $('#sdtedit').val() == false || $('#emailedit').val() == false || $('#statusedit').val() == false || $('#quyenedit').val() == false) {
            alert(" Không được để trống các trường có ký hiệu * ! ");
        } else {
            $.ajax({
                url: "http://localhost:9999/updatend",
                type: "GET",
                data: {
                    hoten: $('#nameedit').val(),
                    sdt: $('#sdtedit').val(),
                    email: $('#emailedit').val(),
                    status: $('#statusedit').val(),
                    quyen: $('#quyenedit').val()
                },
                success: function(data) {
                    alert(data);
                    window.location = " http://localhost:9999/nguoidung";
                },
                error: function(e) {
                    alert(" nhập email không chính xác theo định dạng @gmail.com hoặc đã có email đăng ký ! ");

                }
            });
        }
    });

    $(document).on('change', '.file__image', async function() {
        var masp = $('#id__sp').val();
        var id = $(this).data('gal_id');
        var image = document.getElementById('filesua-' + id).files[0];
        $.ajax({
            url: "http://localhost:9999/updateha",
            type: "GET",
            data: {
                id: id,
                image: image.name,
            },
            success: function(value) {
                alert(value);
                window.location = " http://localhost:9999/hinhanh?id=" + masp;
            },
            error: function(e) {
                alert(" ERROR ! ");
            }
        });
    });
});