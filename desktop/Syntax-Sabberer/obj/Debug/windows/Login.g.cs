﻿#pragma checksum "..\..\..\windows\Login.xaml" "{8829d00f-11b8-4213-878b-770e8597ac16}" "F5BEE1AD0663E08A009CD4CF14F919345693E7E3B8F448ED538538BD84034627"
//------------------------------------------------------------------------------
// <auto-generated>
//     Dieser Code wurde von einem Tool generiert.
//     Laufzeitversion:4.0.30319.42000
//
//     Änderungen an dieser Datei können falsches Verhalten verursachen und gehen verloren, wenn
//     der Code erneut generiert wird.
// </auto-generated>
//------------------------------------------------------------------------------

using Syntax_Sabberer.windows;
using System;
using System.Diagnostics;
using System.Windows;
using System.Windows.Automation;
using System.Windows.Controls;
using System.Windows.Controls.Primitives;
using System.Windows.Data;
using System.Windows.Documents;
using System.Windows.Ink;
using System.Windows.Input;
using System.Windows.Markup;
using System.Windows.Media;
using System.Windows.Media.Animation;
using System.Windows.Media.Effects;
using System.Windows.Media.Imaging;
using System.Windows.Media.Media3D;
using System.Windows.Media.TextFormatting;
using System.Windows.Navigation;
using System.Windows.Shapes;
using System.Windows.Shell;


namespace Syntax_Sabberer.windows {
    
    
    /// <summary>
    /// Login
    /// </summary>
    public partial class Login : System.Windows.Window, System.Windows.Markup.IComponentConnector {
        
        
        #line 30 "..\..\..\windows\Login.xaml"
        [System.Diagnostics.CodeAnalysis.SuppressMessageAttribute("Microsoft.Performance", "CA1823:AvoidUnusedPrivateFields")]
        internal System.Windows.Controls.Border drag;
        
        #line default
        #line hidden
        
        
        #line 38 "..\..\..\windows\Login.xaml"
        [System.Diagnostics.CodeAnalysis.SuppressMessageAttribute("Microsoft.Performance", "CA1823:AvoidUnusedPrivateFields")]
        internal System.Windows.Controls.StackPanel titleBar;
        
        #line default
        #line hidden
        
        
        #line 45 "..\..\..\windows\Login.xaml"
        [System.Diagnostics.CodeAnalysis.SuppressMessageAttribute("Microsoft.Performance", "CA1823:AvoidUnusedPrivateFields")]
        internal System.Windows.Controls.Label closeBtn;
        
        #line default
        #line hidden
        
        
        #line 60 "..\..\..\windows\Login.xaml"
        [System.Diagnostics.CodeAnalysis.SuppressMessageAttribute("Microsoft.Performance", "CA1823:AvoidUnusedPrivateFields")]
        internal System.Windows.Controls.Image settingsBtn;
        
        #line default
        #line hidden
        
        
        #line 84 "..\..\..\windows\Login.xaml"
        [System.Diagnostics.CodeAnalysis.SuppressMessageAttribute("Microsoft.Performance", "CA1823:AvoidUnusedPrivateFields")]
        internal System.Windows.Controls.TextBox usernameInput;
        
        #line default
        #line hidden
        
        
        #line 102 "..\..\..\windows\Login.xaml"
        [System.Diagnostics.CodeAnalysis.SuppressMessageAttribute("Microsoft.Performance", "CA1823:AvoidUnusedPrivateFields")]
        internal System.Windows.Controls.PasswordBox passwordInput;
        
        #line default
        #line hidden
        
        
        #line 114 "..\..\..\windows\Login.xaml"
        [System.Diagnostics.CodeAnalysis.SuppressMessageAttribute("Microsoft.Performance", "CA1823:AvoidUnusedPrivateFields")]
        internal System.Windows.Controls.Border loginBtn;
        
        #line default
        #line hidden
        
        
        #line 146 "..\..\..\windows\Login.xaml"
        [System.Diagnostics.CodeAnalysis.SuppressMessageAttribute("Microsoft.Performance", "CA1823:AvoidUnusedPrivateFields")]
        internal System.Windows.Controls.Label showRegisterBtn;
        
        #line default
        #line hidden
        
        private bool _contentLoaded;
        
        /// <summary>
        /// InitializeComponent
        /// </summary>
        [System.Diagnostics.DebuggerNonUserCodeAttribute()]
        [System.CodeDom.Compiler.GeneratedCodeAttribute("PresentationBuildTasks", "4.0.0.0")]
        public void InitializeComponent() {
            if (_contentLoaded) {
                return;
            }
            _contentLoaded = true;
            System.Uri resourceLocater = new System.Uri("/Syntax-Sabberer;component/windows/login.xaml", System.UriKind.Relative);
            
            #line 1 "..\..\..\windows\Login.xaml"
            System.Windows.Application.LoadComponent(this, resourceLocater);
            
            #line default
            #line hidden
        }
        
        [System.Diagnostics.DebuggerNonUserCodeAttribute()]
        [System.CodeDom.Compiler.GeneratedCodeAttribute("PresentationBuildTasks", "4.0.0.0")]
        [System.ComponentModel.EditorBrowsableAttribute(System.ComponentModel.EditorBrowsableState.Never)]
        [System.Diagnostics.CodeAnalysis.SuppressMessageAttribute("Microsoft.Design", "CA1033:InterfaceMethodsShouldBeCallableByChildTypes")]
        [System.Diagnostics.CodeAnalysis.SuppressMessageAttribute("Microsoft.Maintainability", "CA1502:AvoidExcessiveComplexity")]
        [System.Diagnostics.CodeAnalysis.SuppressMessageAttribute("Microsoft.Performance", "CA1800:DoNotCastUnnecessarily")]
        void System.Windows.Markup.IComponentConnector.Connect(int connectionId, object target) {
            switch (connectionId)
            {
            case 1:
            this.drag = ((System.Windows.Controls.Border)(target));
            
            #line 36 "..\..\..\windows\Login.xaml"
            this.drag.MouseDown += new System.Windows.Input.MouseButtonEventHandler(this.drag_MouseDown);
            
            #line default
            #line hidden
            return;
            case 2:
            this.titleBar = ((System.Windows.Controls.StackPanel)(target));
            return;
            case 3:
            this.closeBtn = ((System.Windows.Controls.Label)(target));
            
            #line 56 "..\..\..\windows\Login.xaml"
            this.closeBtn.MouseDown += new System.Windows.Input.MouseButtonEventHandler(this.closeBtn_MouseDown);
            
            #line default
            #line hidden
            return;
            case 4:
            this.settingsBtn = ((System.Windows.Controls.Image)(target));
            
            #line 67 "..\..\..\windows\Login.xaml"
            this.settingsBtn.MouseDown += new System.Windows.Input.MouseButtonEventHandler(this.settingsBtn_MouseDown);
            
            #line default
            #line hidden
            return;
            case 5:
            this.usernameInput = ((System.Windows.Controls.TextBox)(target));
            return;
            case 6:
            this.passwordInput = ((System.Windows.Controls.PasswordBox)(target));
            return;
            case 7:
            this.loginBtn = ((System.Windows.Controls.Border)(target));
            
            #line 123 "..\..\..\windows\Login.xaml"
            this.loginBtn.MouseDown += new System.Windows.Input.MouseButtonEventHandler(this.loginBtn_MouseDown);
            
            #line default
            #line hidden
            return;
            case 8:
            this.showRegisterBtn = ((System.Windows.Controls.Label)(target));
            
            #line 157 "..\..\..\windows\Login.xaml"
            this.showRegisterBtn.MouseDown += new System.Windows.Input.MouseButtonEventHandler(this.showRegisterBtn_MouseDown);
            
            #line default
            #line hidden
            return;
            }
            this._contentLoaded = true;
        }
    }
}

