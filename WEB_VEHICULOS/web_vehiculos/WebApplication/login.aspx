<%@ Page Title="" Language="C#" MasterPageFile="~/Site.Master" AutoEventWireup="true" CodeBehind="login.aspx.cs" Inherits="WebApplication.login" %>

<asp:Content ID="Content1" ContentPlaceHolderID="MainContent" runat="server">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

  <style>
    .divider:after,
    .divider:before {
      content: "";
      flex: 1;
      height: 1px;
      background: #eee;
    }
    .h-custom {
      height: calc(100% - 73px);
    }
    @media (max-width: 450px) {
      .h-custom {
        height: 100%;
      }
    }
    .btn-floating {
      border-radius: 50%;
      padding: 0.75rem;
    }
    .btn-primary {
      background-color: #0062cc;
      border-color: #005cbf;
    }
    .btn-primary:hover {
      background-color: #0056b3;
      border-color: #0056b3;
    }
    .form-check-input:checked {
      background-color: #0062cc;
      border-color: #005cbf;
    }
    .text-body {
      color: #007bff;
    }
    .text-body:hover {
      color: #0056b3;
    }
    .link-danger {
      color: #dc3545;
    }
    .link-danger:hover {
      color: #c82333;
    }
    
    .btn-primary .fab {
      color: white;
    }
    .password-wrapper {
      position: relative;
    }
    .password-wrapper .toggle-password {
      position: absolute;
      right: 10px;
      top: calc(55% - (1.5em + 1rem + 2px) / 2); 
      transform: translateY(-50%);
      cursor: pointer;
    }
    .password-wrapper .toggle-password .fa-eye, .password-wrapper .toggle-password .fa-eye-slash {
      font-size: 1.2rem; 
    }
  </style>

  <section class="vh-100">
    <div class="container-fluid h-custom">
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-md-9 col-lg-6 col-xl-5">
          <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-login-form/draw2.webp"
            class="img-fluid" alt="Sample image">
        </div>
        <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
          <asp:Panel runat="server">
            <div class="d-flex flex-row align-items-center justify-content-center justify-content-lg-start">
              <p class="lead fw-normal mb-0 me-3">Síguenos en</p>
              <a href="https://github.com/jcz13-ua/hada-proyecto-grupo" target="_blank">
                <button type="button" class="btn btn-primary btn-floating mx-1">
                  <i class="fab fa-github"></i>
                </button>
              </a>

              <a href="https://x.com/OnlyCars_UA" target="_blank">
                <button type="button" class="btn btn-primary btn-floating mx-1">
                  <img src="logimg/x-twitter.svg" alt="X logo" style="width: 1.0rem;">
                </button>
              </a>
              <a href="https://www.instagram.com/onlycars_ua/" target="_blank">
                <button type="button" class="btn btn-primary btn-floating mx-1">
                  <i class="fab fa-instagram"></i>
                </button>
              </a>
            </div>
            <div class="divider d-flex align-items-center my-4">
              <p class="text-center fw-bold mx-3 mb-0">Or</p>
            </div>

            <div class="form-outline mb-4">
              <asp:TextBox ID="txtEmail" runat="server" CssClass="form-control form-control-lg" placeholder="Enter a valid email address" required="required" OnTextChanged="txtEmail_TextChanged" AutoPostBack="true"></asp:TextBox>
              <label class="form-label" for="txtEmail">Email address</label>
            </div>

            <div class="form-outline mb-3 password-wrapper">
              <asp:TextBox ID="txtPassword" runat="server" CssClass="form-control form-control-lg" placeholder="Enter password" required="required" TextMode="Password"></asp:TextBox>
              <span class="toggle-password">
                <i class="fas fa-eye" id="togglePassword"></i>
              </span>
              <label class="form-label" for="txtPassword">Password</label>
              <asp:Label ID="lblErrorMessage" runat="server" Text="" ForeColor="Red"></asp:Label>
            </div>

            <div class="d-flex justify-content-between align-items-center">
              <div class="form-check mb-0">
                <asp:CheckBox ID="chkRememberMe" runat="server" CssClass="form-check-input me-2" />
                <label class="form-check-label" for="chkRememberMe">Recuérdame</label>
              </div>
              <asp:HyperLink ID="lnkForgotPassword" runat="server" NavigateUrl="~/ForgotPassword.aspx" CssClass="text-body">Forgot password?</asp:HyperLink>
            </div>

            <div class="text-center text-lg-start mt-4 pt-2">
              <asp:Button ID="btnLogin" runat="server" Text="Login" CssClass="btn btn-primary btn-lg" style="padding-left: 2.5rem; padding-right: 2.5rem;" OnClick="Inicio" />
              <p class="small fw-bold mt-2 pt-1 mb-0">¿No tienes una cuenta? <asp:HyperLink ID="lnkRegister" runat="server" NavigateUrl="~/register.aspx" CssClass="link-danger">Registrarse</asp:HyperLink></p>
            </div>
          </asp:Panel>
        </div>
      </div>
    </div>
  </section>

  <script>
      document.addEventListener('DOMContentLoaded', function () {
          const togglePassword = document.getElementById('togglePassword');
          const passwordField = document.getElementById('<%= txtPassword.ClientID %>');

          togglePassword.addEventListener('click', function () {
              // Toggle the type attribute
              const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
              passwordField.setAttribute('type', type);
              // Toggle the eye slash icon
              this.classList.toggle('fa-eye');
              this.classList.toggle('fa-eye-slash');
          });
      });
  </script>
</asp:Content>
