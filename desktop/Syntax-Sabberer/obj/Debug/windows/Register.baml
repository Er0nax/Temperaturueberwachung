   M S B A M L   `   `   `  ����J  FSyntax-Sabberer, Version=1.0.0.0, Culture=neutral, PublicKeyToken=nullA%clr-namespace:Syntax_Sabberer.windowsSyntax_Sabberer.windows  5   	   &     Syntax_Sabberer.windows.Register   5   	   R NWindowsBase, Version=4.0.0.0, Culture=neutral, PublicKeyToken=31bf3856ad364e35W SPresentationCore, Version=4.0.0.0, Culture=neutral, PublicKeyToken=31bf3856ad364e35\ XPresentationFramework, Version=4.0.0.0, Culture=neutral, PublicKeyToken=31bf3856ad364e35D 9http://schemas.microsoft.com/winfx/2006/xaml/presentation    5   	   R NSystem.Xaml, Version=4.0.0.0, Culture=neutral, PublicKeyToken=b77a5c561934e089:x,http://schemas.microsoft.com/winfx/2006/xaml     5   	   @d2http://schemas.microsoft.com/expression/blend/2008     5   	   Jmc;http://schemas.openxmlformats.org/markup-compatibility/2006     5   	   7local%clr-namespace:Syntax_Sabberer.windows     5   	     � Title$  Register��5   	   $	��450��5	   	   $	��300��5
   	    � WindowStartupLocation$ CenterScreen=�5   	    � 
ResizeMode$ NoResize=�5   	    � Icon$  /assets/images/favicon.ico��5   	    � WindowStyle$
 None=�5   	    � AllowsTransparency . ��5   	   Z� .��5      �� ���	#FF111111 �� CornerRadius$ 5��5      ._�5   
   �  � RowDefinitions 5      �� 5      $��30 �6    �� 5      $��30 �6    �� 5      �� 5      $��50 �6    �� 5      $��50 �6    �� 5      $��50 �6    �� 5      �� 5      .+�5      �� -   5         ��Name$
 drag��5      
���   �	 J� Opacity$		 0.3Q�5!      $��0��5"      $��1��5#      
 � Cursor$

 Hand��5$      $ 5 5 0 0��5%      5&      �� 5(      -   5         ��Name$ titleBar��5(      $��0��5)      $

 Hand��5*       �� Orientation$ Vertical=�5+      $��Right=�5,      .+�5.      �� -   5         ��Name$ closeBtn��5.      $��X��5/      ���	#FFFF4242$��0q�51      $��18(�52      $��30��53      $

 Hand��54      $��30��55      $��Center=�56      $��Center=�57      $
��Bold"�58      59      5;      �� 5=      -   5         ��Name$ settingsBtn��5=      $��0��5>      $��20��5?      $
��Left=�5@      $��5 0 0 0q�5A      $

 Hand��5B      $'��!/assets/images/settings-white.png��5C      5D      �� 5F      $��2��6   $��2��5G      $��Syntax-Sabberer��5H      $��Center=�5I      $��Center=�5J      $��20(�5K      
�������$
��Bold"�5M      �� 5O      $��3��6   $��2��5P      
����ح�$��0 0 0 1q�5R      $��50 10 50 10q�5S      ._�5U      �� -   5         ��Name$ usernameInput��5U      $��Username��5V      
�������$��Center=�5Z      $��Center=�5[       �� SelectionBrush
 ����� �� 
CaretBrush
 �������5W      Z� ��5X      Z� 5]      5_      �� 5a      $��4��6   $��2��5b      
����ح�$��0 0 0 1q�5d      $��50 10 50 10q�5e      ._�5g      G� -   5         G�Name$ passwordInput��5g       G� Password$ password��5h      
�������$��Center=�5l      $��Center=�5m       G� SelectionBrush
 ����� G� 
CaretBrush
 �������5i      Z� ��5j      Z� 5o      5q      �� 5s      $��5��6   $��2��5t      
����ح�$��0 0 0 1q�5v      $��50 10 50 10q�5w      ._�5y      G� -   5        $ passwordRepeatInput��5y      $ password��5z      
�������$��Center=�5~      $��Center=�5      
 �����
 �������5{      Z� ��5|      Z� 5�      5�      �� 5�      -   5        $ registerBtn��5�      $��6��5�      $��2��5�      $��30��5�      $��	50 0 50 0q�5�      $

 Hand��5�      $ 5��5�      
����ح�$��1q�5�      ��5�      �� 5�       �� EndPoint$	 1,1&�6*    �� 
StartPoint$	 0,0&�5�   *   .��5�      �  � Color$ 	#FF372B7B��6'   � 5�      $ 	#FF286370��6'    � Offset$ 1Q�5�   '   5�       J� Effect 5�      3  -System.Windows.Media.Effects.DropShadowEffect  5�         
BlurRadius$ 10Q�6'      Opacity$	 0.5Q�5�   '   ._�5�      �� $��Register��6   
�������$��Center=�5�      $��Center=�5�      5�      �� 5�      -	   5        $ showLoginBtn��5�      $��7��5�      $��2��5�      $

 Hand��5�      $��Center=�5�      $��Center=�5�      $��50 10 50 10q�5�      
�������$��30��5�      $��0q�5�      $ ��I already have an account.��5�      5�      5�      5�      5�      