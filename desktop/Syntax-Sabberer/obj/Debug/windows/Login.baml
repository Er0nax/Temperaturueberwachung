   M S B A M L   `   `   `  ����J  FSyntax-Sabberer, Version=1.0.0.0, Culture=neutral, PublicKeyToken=nullA%clr-namespace:Syntax_Sabberer.windowsSyntax_Sabberer.windows  5   	   #    Syntax_Sabberer.windows.Login   5   	   R NWindowsBase, Version=4.0.0.0, Culture=neutral, PublicKeyToken=31bf3856ad364e35W SPresentationCore, Version=4.0.0.0, Culture=neutral, PublicKeyToken=31bf3856ad364e35\ XPresentationFramework, Version=4.0.0.0, Culture=neutral, PublicKeyToken=31bf3856ad364e35D 9http://schemas.microsoft.com/winfx/2006/xaml/presentation    5   	   R NSystem.Xaml, Version=4.0.0.0, Culture=neutral, PublicKeyToken=b77a5c561934e089:x,http://schemas.microsoft.com/winfx/2006/xaml     5   	   @d2http://schemas.microsoft.com/expression/blend/2008     5   	   Jmc;http://schemas.openxmlformats.org/markup-compatibility/2006     5   	   7local%clr-namespace:Syntax_Sabberer.windows     5   	     � Title$  Login��5   	   $	��450��5	   	   $	��300��5
   	    � WindowStartupLocation$ CenterScreen=�5   	    � 
ResizeMode$ NoResize=�5   	    � Icon$  /assets/images/favicon.ico��5   	    � WindowStyle$
 None=�5   	    � AllowsTransparency . ��5   	   Z� .��5      �� ���	#FF111111 �� CornerRadius$ 5��5      ._�5   
   �  � RowDefinitions 5      �� 5      $��30 �6    �� 5      $��30 �6    �� 5      �� 5      $��50 �6    �� 5      $��50 �6    �� 5      �� 5      .+�5      �� -   5         ��Name$
 drag��5      
���   �	 J� Opacity$		 0.3Q�5       $��0��5!      
 � Cursor$

 Hand��5"      $ 5 5 0 0��5#      5$      �� 5&      -   5         ��Name$ titleBar��5&      $

 Hand��5'      $��30��5(      $��0��5)       �� Orientation$ Vertical=�5*      $��Right=�5+      .+�5-      �� -   5         ��Name$ closeBtn��5-      $��X��5.      ���	#FFFF4242$��0q�50      $��18(�51      $��30��52      $

 Hand��53      $��30��54      $��Center=�55      $��Center=�56      $
��Bold"�57      58      5:      �� 5<      -   5         ��Name$ settingsBtn��5<      $��0��5=      $��20��5>      $
��Left=�5?      $��5 0 0 0q�5@      $

 Hand��5A      $'��!/assets/images/settings-white.png��5B      5C      �� 5E      $��2��6   $��2��5F      $��Syntax-Sabberer��5G      $��Center=�5H      $��Center=�5I      $��20(�5J      
�������$
��Bold"�5L      �� 5N      $��3��6   $��2��5O      
����ح�$��0 0 0 1q�5Q      $��50 10 50 10q�5R      ._�5T      �� -   5         ��Name$ usernameInput��5T      $	��Tim��5U      
�������$��Center=�5Y      $��Center=�5Z       �� SelectionBrush
 ����� �� 
CaretBrush
 �������5V      Z� ��5W      Z� 5\      5^      �� 5`      $��4��6   $��2��5a      
����ح�$��0 0 0 1q�5c      $��50 10 50 10q�5d      ._�5f      G� -   5         G�Name$ passwordInput��5f      
�������$��Center=�5j      $��Center=�5k       G� Password$ admin��5l       G� SelectionBrush
 ����� G� 
CaretBrush
 �������5g      Z� ��5h      Z� 5n      5p      �� 5r      -   5        $ loginBtn��5r      $��5��5s      $��2��5t      $��30��5u      $��	50 0 50 0q�5v      $

 Hand��5w      $ 5��5x      
����ح�$��1q�5z      ��5}      �� 5~       �� EndPoint$	 1,1&�6*    �� 
StartPoint$	 0,0&�5   *   .��5�      �  � Color$ 	#FF372B7B��6'   � 5�      $ 	#FF286370��6'    � Offset$ 1Q�5�   '   5�       J� Effect 5�      3  -System.Windows.Media.Effects.DropShadowEffect  5�         
BlurRadius$ 10Q�6'      Opacity$	 0.5Q�5�   '   ._�5�      �� $��Login��6   
�������$��Center=�5�      $��Center=�5�      5�      �� 5�      -   5        $ showRegisterBtn��5�      $��6��5�      $��2��5�      $

 Hand��5�      $��Center=�5�      $��Center=�5�      $��50 10 50 10q�5�      
�������$��30��5�      $��0q�5�      $!��I dont have an account yet.��5�      5�      5�      5�      5�      