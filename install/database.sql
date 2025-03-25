SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Table structure for table `app_admin`
--

CREATE TABLE `app_admin` (
  `id` int(11) NOT NULL,
  `profile_image` varchar(100) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `status` enum('A','I','D','P') NOT NULL DEFAULT 'P' COMMENT 'A:Approved ,P:Pending ,I:Inactive,D:Deleted,C:Completed',
  `profile_status` enum('V','N') NOT NULL DEFAULT 'N' COMMENT 'V:Verify , N:Not Verify',
  `type` enum('A','V') NOT NULL DEFAULT 'A' COMMENT 'A:Admin,V:Vendor',
  `my_wallet` decimal(18,2) NOT NULL,
  `company_name` varchar(100) DEFAULT NULL,
  `website` varchar(100) DEFAULT NULL,
  `package_id` int(11) NOT NULL DEFAULT '0',
  `profile_text` text,
  `fb_link` varchar(100) DEFAULT NULL,
  `twitter_link` varchar(100) DEFAULT NULL,
  `google_link` varchar(100) DEFAULT NULL,
  `default_password_changed` int(11) NOT NULL DEFAULT '0',
  `reset_password_check` int(11) NOT NULL DEFAULT '0',
  `reset_password_requested_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `app_appointment_payment`
--

CREATE TABLE `app_appointment_payment` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL DEFAULT '0',
  `vendor_id` int(11) NOT NULL DEFAULT '0',
  `event_id` int(11) NOT NULL DEFAULT '0',
  `booking_id` int(11) NOT NULL DEFAULT '0',
  `payment_id` varchar(255) NOT NULL,
  `customer_payment_id` varchar(255) NOT NULL,
  `transaction_id` varchar(255) NOT NULL,
  `payment_price` decimal(18,2) NOT NULL DEFAULT '0.00',
  `vendor_price` decimal(18,2) NOT NULL,
  `admin_price` decimal(18,2) NOT NULL,
  `failure_code` varchar(255) DEFAULT NULL,
  `failure_message` text,
  `payment_method` varchar(100) NOT NULL,
  `payment_status` varchar(100) NOT NULL,
  `transfer_status` enum('S','P','F') NOT NULL DEFAULT 'P' COMMENT 'S:Success, F:Fail, P:Pending',
  `created_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `app_chat`
--

CREATE TABLE `app_chat` (
  `id` int(11) NOT NULL,
  `chat_id` int(11) NOT NULL DEFAULT '0',
  `from_id` int(11) NOT NULL DEFAULT '0',
  `to_id` int(11) NOT NULL DEFAULT '0',
  `message` text NOT NULL,
  `chat_type` enum('C','NC') NOT NULL DEFAULT 'NC' COMMENT 'C:Customer:NC:Not Customer',
  `msg_read` enum('Y','N') NOT NULL DEFAULT 'N',
  `created_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `app_chat_master`
--

CREATE TABLE `app_chat_master` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL DEFAULT '0',
  `vendor_id` int(11) NOT NULL DEFAULT '0',
  `created_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `app_city`
--

CREATE TABLE `app_city` (
  `city_id` int(11) NOT NULL,
  `city_title` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `city_status` enum('A','I') NOT NULL DEFAULT 'A' COMMENT 'A=active,I=inactive',
  `city_created_by` int(11) NOT NULL DEFAULT '0',
  `city_created_on` datetime DEFAULT NULL,
  `city_updated_on` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `app_coupon`
--

CREATE TABLE `app_coupon` (
  `id` int(11) NOT NULL,
  `title` text CHARACTER SET utf8 NOT NULL,
  `valid_till` date NOT NULL,
  `event_id` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `discount_type` enum('P','A') NOT NULL COMMENT 'P=Percentage, A=Amount',
  `discount_value` decimal(18,2) NOT NULL,
  `status` enum('A','I','E') NOT NULL COMMENT 'A=Active,I=Inactive,E=Expire',
  `created_by` int(11) NOT NULL,
  `created_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `app_customer`
--

CREATE TABLE `app_customer` (
  `id` int(11) NOT NULL,
  `profile_image` varchar(100) NOT NULL,
  `first_name` varchar(100) CHARACTER SET utf8 NOT NULL,
  `last_name` varchar(100) CHARACTER SET utf8 NOT NULL,
  `email` varchar(100) CHARACTER SET utf8 NOT NULL,
  `password` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `status` enum('A','I','D') NOT NULL DEFAULT 'A' COMMENT 'A:Active,I:Inactive,D:Deleted',
  `default_password_changed` int(11) NOT NULL DEFAULT '0',
  `reset_password_check` int(11) NOT NULL DEFAULT '0',
  `reset_password_requested_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int(11) NOT NULL DEFAULT '0',
  `created_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `app_email_setting`
--

CREATE TABLE `app_email_setting` (
  `id` int(11) NOT NULL,
  `smtp_host` varchar(255) NOT NULL,
  `smtp_username` varchar(255) NOT NULL,
  `smtp_password` varchar(255) NOT NULL,
  `smtp_port` int(11) NOT NULL,
  `smtp_secure` varchar(255) NOT NULL,
  `email_from_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `app_event`
--

CREATE TABLE `app_event` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL DEFAULT '0',
  `title` varchar(100) CHARACTER SET utf8 NOT NULL,
  `description` text CHARACTER SET utf8 NOT NULL,
  `days` text NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `slot_time` int(11) NOT NULL DEFAULT '15',
  `monthly_allow` int(11) NOT NULL DEFAULT '1',
  `city` varchar(100) NOT NULL,
  `location` varchar(100) NOT NULL,
  `is_display_address` enum('Y','N') NOT NULL DEFAULT 'N' COMMENT 'Y=yes,N=no',
  `address` text,
  `latitude` double(18,2) NOT NULL DEFAULT '0.00',
  `longitude` double(18,2) NOT NULL DEFAULT '0.00',
  `image` text NOT NULL,
  `payment_type` enum('F','P') NOT NULL DEFAULT 'F' COMMENT 'F:Free,P:Paid',
  `price` decimal(18,2) NOT NULL DEFAULT '0.00',
  `discount` decimal(18,2) NOT NULL DEFAULT '0.00',
  `discounted_price` decimal(18,2) DEFAULT '0.00',
  `from_date` date DEFAULT NULL,
  `to_date` date DEFAULT NULL,
  `status` enum('A','I') NOT NULL COMMENT 'A:Active,I:Inactive',
  `seo_description` text,
  `seo_keyword` varchar(255) DEFAULT NULL,
  `seo_og_image` varchar(100) DEFAULT NULL,
  `created_by` int(11) NOT NULL DEFAULT '0',
  `created_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `app_event_book`
--

CREATE TABLE `app_event_book` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL DEFAULT '0',
  `description` text NOT NULL,
  `start_date` date NOT NULL DEFAULT '0000-00-00',
  `start_time` time NOT NULL DEFAULT '00:00:00',
  `slot_time` int(11) NOT NULL DEFAULT '0',
  `event_id` int(11) NOT NULL DEFAULT '0',
  `price` decimal(18,2) NOT NULL,
  `vendor_price` decimal(18,2) NOT NULL,
  `admin_price` decimal(18,2) NOT NULL,
  `invoice_file` varchar(100) DEFAULT NULL,
  `payment_status` enum('S','F','P') NOT NULL DEFAULT 'P' COMMENT 'S:Success, F:Fail, P:Pending',
  `status` enum('A','P','R','D','C') NOT NULL DEFAULT 'P' COMMENT 'A:Approved ,P:Pending , R:Rejected ,D:Deleted,C:Completed',
  `created_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `app_event_category`
--

CREATE TABLE `app_event_category` (
  `id` int(11) NOT NULL,
  `title` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `status` enum('A','I') NOT NULL DEFAULT 'A' COMMENT 'A=active,I=inactive',
  `created_by` int(11) NOT NULL DEFAULT '0',
  `created_on` datetime DEFAULT NULL,
  `updated_on` datetime DEFAULT NULL,
  `event_category_image` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `app_language`
--

CREATE TABLE `app_language` (
  `id` int(11) NOT NULL,
  `title` text CHARACTER SET utf8 NOT NULL,
  `db_field` text CHARACTER SET utf8 NOT NULL,
  `status` enum('A','I') NOT NULL DEFAULT 'A' COMMENT 'A=active,I=inactive',
  `created_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `app_language`
--

INSERT INTO `app_language` (`id`, `title`, `db_field`, `status`, `created_date`) VALUES
(1, 'english', 'english', 'A', '2018-07-13 17:17:42'),
(4, 'portuguese', 'portuguese', 'A', '2018-07-31 18:07:45');

-- --------------------------------------------------------

--
-- Table structure for table `app_language_data`
--

CREATE TABLE `app_language_data` (
  `id` int(11) NOT NULL,
  `default_text` longtext CHARACTER SET utf8 NOT NULL,
  `english` text CHARACTER SET utf8,
  `portuguese` text CHARACTER SET utf8
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `app_language_data`
--

INSERT INTO `app_language_data` (`id`, `default_text`, `english`, `portuguese`) VALUES
(1, 'login', 'Login', 'Entrar'),
(2, 'logout', 'Logout', 'Sair'),
(3, 'return', 'Return', 'Retorna'),
(4, 'now', 'Now', 'Agora'),
(5, 'required_message', 'This field is required.', 'Este campo é obrigatório.'),
(6, 'login_success', 'You have logged in successfully.', 'Você está logado com sucesso.'),
(7, 'login_failure', 'Please check your email or password and try again.', 'Por favor, verifique seu e-mail ou senha e tente novamente.'),
(8, 'forgot_password', 'Forgot Password', 'Esqueceu a senha'),
(9, 'forgot_mail_message', 'Need to reset your password?', 'Precisa redefinir sua senha?'),
(10, 'forgot_mail_content', 'We have received a request to reset your password. You can change your password by hitting the button below.', 'Recebemos uma solicitação para redefinir sua senha. Você pode alterar sua senha clicando no botão abaixo.'),
(11, 'reset_password', 'Reset Password', 'Redefinir Senha'),
(12, 'forgot_success', 'Reset password link has been sent successfully.', 'O link para redefinir senha foi enviado com sucesso.'),
(13, 'forgot_failure', 'Email not registered with system.', 'E-mail não registrado no sistema.'),
(14, 'reset_failure', 'Reset password link has been expired. Please try again.', 'O link para redefinir senha expirou. Por favor, tente novamente.'),
(15, 'invalid_request', 'Invalid request. Please try again.', 'Pedido inválido. Por favor, tente novamente.'),
(16, 'reset_success', 'Your password has been changed successfully.', 'Sua senha foi alterada com sucesso.'),
(17, 'update_password', 'Update Password', 'Atualizar senha'),
(18, 'current_password_failure', 'Your old password is invalid. Please try again.', 'Sua senha antiga é inválida. Por favor, tente novamente.'),
(19, 'profile_success', 'Your profile has been updated successfully.', 'Seu perfil foi atualizado com sucesso.'),
(20, 'logout_success', 'Logout successfully...', 'Logout com sucesso ...'),
(21, 'login_required_for_book', 'You can not book slot. please login and try again.', 'Você não pode reservar slot. Por favor, faça o login e tente novamente.'),
(22, 'vendor_verify_failure', 'Account verification link has been expired. Please try again.', 'O link de confirmação da conta expirou. Por favor, tente novamente.'),
(23, 'already_vendor_verify', 'Account already verify.', 'Conta já verificar.'),
(24, 'account_verify_success', 'Account verified successfully.', 'Conta verificada com sucesso.'),
(25, 'vendor_not_verify', 'Account not verified. <br> <a href="{resend_url}">Resend</a>  verification link', 'Conta não confirmada. Reenviar link de verificação'),
(26, 'account_verification_content', 'Your account has been created successfully.Please click on verification button to activate account.', 'Sua conta foi criada com sucesso. Clique no botão de verificação para ativar a conta.'),
(27, 'image', 'Image', 'Imagem'),
(28, 'edit', 'Edit', 'Editar'),
(29, 'update', 'Update', 'Atualizar'),
(30, 'add', 'Add', 'Adicionar'),
(31, 'email', 'Email', 'O email'),
(32, 'thank', 'Thank', 'Obrigado'),
(33, 'you', 'you', 'Você'),
(34, 'password', 'Password', 'Senha'),
(35, 'first_name', 'First Name', 'Primeiro nome'),
(36, 'last_name', 'Last Name', 'Último nome'),
(37, 'phone', 'Phone', 'telefone'),
(38, 'choose_file', 'Choose File', 'Escolher arquivo'),
(39, 'submit', 'Submit', 'Enviar'),
(40, 'subject', 'Subject', 'Sujeito'),
(41, 'purpose', 'Purpose', 'Propósito'),
(42, 'description', 'Description', 'Descrição'),
(43, 'appointment_date', 'Appointment Date', 'Data do encontro'),
(44, 'created_date', 'Created Date', 'data criada'),
(45, 'action', 'Action', 'Action'),
(46, 'info', 'Info', 'Info'),
(47, 'password_length', 'Password must be 8 characters long.', 'A senha deve ter 8 caracteres.'),
(48, 'password_lowercase', 'Must contain at least one lowercase letter.', 'Deve conter pelo menos uma letra minúscula.'),
(49, 'password_uppercase', 'Must contain at least one uppercase letter.', 'Deve conter pelo menos uma letra maiúscula.'),
(50, 'password_numeric', 'Must contain at least one numeric digit and one special character.', 'Deve conter pelo menos um dígito numérico e um caractere especial.'),
(51, 'confirm_password', 'Confirm Password', 'Confirme a Senha'),
(52, 'Change_password', 'Change Password', 'Mudar senha'),
(53, 'payment_history', 'Payment History', 'Histórico de pagamento'),
(54, 'update', 'Update', 'Atualizar'),
(55, 'profile_image', 'Profile Image', 'Imagem de perfil'),
(56, 'upload_your_file', 'Upload your file', 'Envie seu arquivo'),
(57, 'manage', 'Manage', 'Gerir'),
(58, 'event', 'Event', 'Evento'),
(59, 'appointment', 'Appointment', 'Compromisso'),
(60, 'delete', 'Delete', 'Excluir'),
(61, 'confirm', 'Confirm', 'confirme'),
(62, 'close', 'Close', 'Fechar'),
(63, 'total', 'Total', 'Total'),
(64, 'customer', 'Customer', 'Cliente'),
(66, 'active', 'Active', 'Ativo'),
(67, 'inactive', 'Inactive', 'Inativo'),
(68, 'title', 'Title', 'Título'),
(69, 'select', 'Select', 'Selecione'),
(70, 'delete_confirm', 'Are you sure you want to delete this record?', 'Tem certeza de que deseja excluir este registro?'),
(71, 'home', 'Home', 'Casa'),
(72, 'new_account_mail', ' Your account has been created successfully.Your login credential are stated as below.', 'Sua conta foi criada com sucesso. Sua credencial de login é indicada abaixo.'),
(73, 'admin_login', 'Admin Login', 'Login de administrador'),
(74, 'reserved_message', ' All Rights Reserved.', 'Todos os direitos reservados.'),
(75, 'protected_message', 'This is login protected. Please login now to view this.', 'Isso é protegido por login. Por favor faça o login agora para ver isto.'),
(76, 'status', 'Status', 'Status'),
(77, 'save', 'Save', 'Salve '),
(78, 'profile', 'Profile', 'Perfil'),
(79, 'facebook_link', 'Facebook Link', 'Link do Facebook'),
(80, 'twitter_link', 'Twitter Link', 'Twitter Link'),
(81, 'google_link', 'Google+ Link', 'Link do Google+'),
(82, 'profile_text', 'Profile Text', 'Texto do perfil'),
(83, 'profile_under_review', 'Your account is under verification. You are not allowed view this.', 'Sua conta está sob verificação. Você não tem permissão para ver isso.'),
(87, 'purchase', 'Purchase', 'Compra'),
(88, 'message', 'Message', 'mensagem'),
(89, 'no_found', 'No Found', 'Não encontrado'),
(90, 'my_amount', 'My Amount', 'Minha quantia'),
(91, 'view_details', 'View Details', 'Ver detalhes'),
(92, 'appointment_details', 'Appointment Details', 'Detalhes do compromisso'),
(93, 'profile_setting', 'Profile Setting', 'Configuração de perfil'),
(94, 'dashboard', 'Dashboard', 'painel de controle'),
(95, 'customer', 'Customer', 'Cliente'),
(97, 'site_setting', 'Site Setting', 'Configuração do site'),
(98, 'email_setting', 'Email Setting', 'Configuração de email'),
(99, 'delete_install', 'Please delete install directory.', 'Por favor, apague o diretório de instalação.'),
(100, 'upcoming_appointment', 'Upcoming Appointment', 'Próximo compromisso'),
(101, 'mandatory_update', 'Mandatory Update', 'Atualização Obrigatória'),
(102, 'mandatory_message', 'Please follow below steps to getting started with event.', 'Por favor, siga os passos abaixo para começar o evento.'),
(103, 'mandatory_category', 'Please insert minimum one event category', 'Por favor, insira uma categoria de evento mínima'),
(104, 'mandatory_payment', 'Please select payment method', 'Por favor, selecione o método de pagamento'),
(105, 'mandatory_city', 'Please insert minimum one city', 'Por favor insira uma cidade mínima'),
(106, 'mandatory_location', 'Please insert minimum one location', 'Por favor insira uma cidade mínima...'),
(109, 'appointment_booking', 'Appointment Booking', 'Reserva de nomeação'),
(110, 'back_top', 'Back To Top', 'De volta ao topo'),
(111, 'customer_profile', 'Customer Profile', 'Perfil do Cliente'),
(112, 'register', 'Register', 'registo'),
(113, 'package', 'Package', 'Pacote'),
(114, 'vendor_register', 'Vendor Register', 'Registo de Fornecedores'),
(115, 'vendor_registration', 'Vendor Registration', 'Registro de Fornecedores'),
(116, 'account_registration', 'Account Registration', 'Registro de conta'),
(117, 'register_mail_message', 'Your account has been created successfully. Please login to your credential.', 'Sua conta foi criada com sucesso. Por favor, faça o login na sua credencial.'),
(118, 'register_success', 'Your account has been created successfully.', 'Sua conta foi criada com sucesso.'),
(119, 'customer_login', 'Customer Login', 'Login do cliente'),
(120, 'create_account', 'Create an account', 'Crie a sua conta aqui'),
(121, 'dont_have_account', 'Don`t have an account', 'Não tem uma conta'),
(122, 'customer_login', 'Customer Login', 'Login do cliente'),
(123, 'click_here', 'Click Here', 'Clique aqui'),
(124, 'morning', 'Morning', 'Manhã'),
(125, 'noon', 'Noon', 'Meio-dia'),
(126, 'booking_insert', 'Appointment has been booked successfully', 'Compromisso foi reservado com sucesso'),
(127, 'booking_update', 'Appointment has been updated successfully', 'Compromisso foi atualizado com sucesso'),
(128, 'appointment_delete', 'Appointment has been deleted successfully.', 'Compromisso foi excluído com sucesso.'),
(129, 'select_a_day', 'Select a Day', 'Selecione um dia'),
(130, 'today', 'Today', 'Hoje'),
(131, 'available', 'Available', 'acessível'),
(132, 'unavailable', 'Unavailable', 'Indisponível'),
(133, 'today_unavailable', 'Today Unavailable', 'Hoje indisponível'),
(134, 'select_a_time', 'Select a Time', 'Selecione um horário'),
(135, 'booking', 'Booking', 'Reserva'),
(136, 'book', 'Book', 'Livro'),
(137, 'appointment_time', 'Appointment Time', 'Hora do compromisso'),
(138, 'book_your_event', 'Book Your Event', 'Reserve seu evento'),
(139, 'event_information', 'Event Information', 'Informação do Evento'),
(140, 'event_category_image', 'Category Image', 'Informação do Evento...'),
(141, 'user_registration', 'User Registration', 'Registro do usuário'),
(142, 'event_time', '{slot_time} Minute', '{slot_time} Minuto'),
(143, 'rating', 'Rating', 'Avaliação'),
(144, 'on_cash', 'On Cash', 'Em dinheiro'),
(145, 'debit_card', 'Cards (Credit/Debit)', 'Cartões (crédito / débito)'),
(146, 'card_number', 'Credit/Debit Card Number', 'Número do cartão de crédito / débito'),
(147, 'expiry', 'Expiry (MM/YY)', 'Expiração (MM / AA)'),
(148, 'payment', 'Payment', 'Forma de pagamento'),
(149, 'cvv', 'CVV', 'CVV'),
(150, 'name_on_card', 'Name on Card', 'Nome no cartão'),
(151, 'approved', 'Approved', 'Aprovado'),
(152, 'pending', 'Pending', 'Pendente'),
(153, 'rejected', 'Rejected', 'Rejeitado'),
(154, 'deleted', 'Deleted', 'Excluído'),
(155, 'view_event', 'View Event', 'Visualizar evento'),
(156, 'event_details', 'Event Details', 'detalhes do evento'),
(157, 'booking_date', 'Booking Date', 'Data de reserva'),
(158, 'details', 'Details', 'Detalhes'),
(159, 'profile_text_content', 'Welcome', 'Bem vinda'),
(160, 'customer_name', 'Customer Name', 'nome do cliente'),
(161, 'event_category_exist', 'You are not allowed to delete this category.', 'Você não tem permissão para excluir esta categoria.'),
(162, 'appointment_date', 'Appointment Date', 'Data do encontro'),
(163, 'slot_time', 'Slot Time', 'Intervalo de tempo'),
(164, 'in_min', 'In Min.', 'Em min.'),
(165, 'minute', 'Minute', 'Minuto'),
(166, 'change_status', 'Change Status', 'Alterar status'),
(167, 'appointment_status', 'Appointment has been {status}.', 'O compromisso foi {status}.'),
(168, 'appointment_action', 'Appointment Action', 'Ação de compromisso'),
(169, 'completed', 'Completed', 'Concluído'),
(170, 'success', 'Success', 'Sucesso'),
(171, 'failed', 'Failed', 'Falhou'),
(172, 'pending', 'Pending', 'Pendente'),
(173, 'customer_deleted', 'Customer has been deleted successfully.', 'O cliente foi excluído com sucesso.'),
(174, 'customer_status', 'Customer status has been changed successfully.', 'O status do cliente foi alterado com sucesso.'),
(175, 'customer_email', 'Customer Email', 'Email do cliente'),
(176, 'event_update', 'Event has been updated successfully.', 'Evento foi atualizado com sucesso.'),
(177, 'event_insert', 'Event has been inserted successfully.', 'Evento foi inserido com sucesso.'),
(178, 'event_delete', 'Event has been deleted successfully.', 'Evento foi excluído com sucesso.'),
(179, 'event_category_update', 'Event Category has been updated successfully.', 'A categoria do evento foi atualizada com sucesso.'),
(180, 'event_category_insert', 'Event Category has been inserted successfully.', 'A categoria do evento foi inserida com sucesso.'),
(181, 'event_category_delete', 'Event Category has been deleted successfully.', 'A categoria do evento foi excluída com sucesso.'),
(182, 'event_book_Appointment', 'Event Cannot delete.This event appointment booked.', 'Evento não pode excluir.Este compromisso de evento reservado.'),
(183, 'days', 'Days', 'Dias'),
(184, 'monday', 'Monday', 'Segunda-feira'),
(185, 'tuesday', 'Tuesday', 'terça'),
(186, 'wednesday', 'Wednesday', 'Quarta-feira'),
(187, 'thursday', 'Thursday', 'Quinta-feira'),
(188, 'friday', 'Friday', 'Sexta-feira'),
(189, 'saturday', 'Saturday', 'sábado'),
(190, 'sunday', 'Sunday', 'domingo'),
(191, 'start_time', 'Start Time', 'Hora de início'),
(192, 'end_time', 'End Time', 'Fim do tempo'),
(193, 'slot_time', 'Slot Time', 'Intervalo de tempo'),
(194, 'per_allow', 'Per Customer Monthly Book', 'Por livro mensal do cliente'),
(195, 'total_booking', 'Total Booking', 'Reserva total'),
(196, 'select_city', 'Select City', 'Selecione a cidade'),
(197, 'select_location', 'Select Location', 'Selecione o local'),
(198, 'select_city_first', 'Select City First', 'Selecione a cidade primeiro'),
(199, 'event_image', 'Event Image', 'Imagem do Evento'),
(200, 'more', 'More', 'Mais'),
(201, 'event_image_preview', 'Event Image Preview', 'Visualização de imagem de evento'),
(202, 'price', 'Price', 'Preço'),
(203, 'free', 'Free', 'Livre'),
(204, 'paid', 'Paid', 'Pago'),
(205, 'manage_event_category', 'Manage Event Category', 'Gerenciar categoria de evento'),
(206, 'add_event_category', 'Add Event Category', 'Adicionar categoria de evento'),
(207, 'event_category', 'Event Category', 'Categoria do Evento'),
(208, 'category', 'Category', 'Categoria'),
(209, 'site_setting', 'Site Setting', 'Configuração do site'),
(210, 'site_setting_update', 'Site setting details updated successfully.', 'Detalhes da configuração do site atualizados com sucesso.'),
(211, 'smtp_update', 'Smtp details updated successfully.', 'Detalhes do Smtp atualizados com sucesso.'),
(212, 'valid_image', 'Please select valid image(jpg, png, jpeg, gif extension only)', 'Por favor selecione uma imagem válida (jpg, png, jpeg, gif only)'),
(213, 'valid_logo', 'Please check your image. It must be in minimum dimension of 241 x 61', 'Por favor, verifique sua imagem. Deve estar na dimensão mínima de 241 x 61'),
(214, 'valid_banner', 'Please check your image. It must be in minimum dimension of 1900 x 500', 'Por favor, verifique sua imagem. Deve estar na dimensão mínima de 1900 x 500'),
(215, 'valid_logo_size', 'Size must be minimum of 241*61', 'O tamanho deve ser mínimo de 241 * 61'),
(216, 'valid_banner_size', 'Size must be minimum of 1900*500', 'O tamanho deve ser mínimo de 241 * 61...'),
(217, 'something_wrong_group', 'Something wrong with this group', 'Algo de errado com este grupo'),
(218, 'something_wrong', 'Something wrong.', 'Algo errado.'),
(219, 'smtp_host', 'Smtp Host', 'Host Smtp'),
(220, 'smtp_secure', 'Smtp Secure', 'Smtp Secure'),
(221, 'username', 'Username', 'Nome de usuário'),
(222, 'port', 'Port', 'Porta'),
(223, 'from_name', 'From Name', 'De nome'),
(224, 'site_name', 'Site Name', 'Nome do site'),
(225, 'site_email', 'Site Email', 'E-mail do site'),
(226, 'site_phone', 'Site Phone', 'Site Phone'),
(227, 'address', 'Address', 'Endereço'),
(228, 'language', 'Language', 'Língua'),
(229, 'next', 'Next', 'Próximo'),
(230, 'basic', 'Basic', 'Basic'),
(231, 'information', 'Information', 'Em formação'),
(232, 'social', 'Social', 'Social'),
(233, 'media', 'Media', 'meios de comunicação'),
(234, 'personal', 'Personal', 'Pessoal'),
(235, 'data', 'Data', 'Dados'),
(236, 'terms_conditions', 'Terms and Conditions', 'Termos e Condições'),
(237, 'previous', 'Previous', 'Anterior'),
(238, 'facebook', 'Facebook', 'Facebook'),
(239, 'google+', 'Google+', 'Google+'),
(240, 'twitter', 'Twitter', 'Twitter'),
(241, 'instagram', 'Instagram', 'Instagram'),
(242, 'linkdin', 'Linkdin', 'Linkedin'),
(243, 'link', 'Link', 'Ligação'),
(244, 'company', 'Company', 'Empresa'),
(245, 'english', 'English', 'Inglês'),
(246, 'logo', 'Logo', 'Logotipo'),
(247, 'time_zone', 'TimeZone', 'Logotipo...'),
(248, 'rating_review', 'Rating / Review', 'Avaliação / Revisão'),
(249, 'review', 'Review', 'Reveja'),
(250, 'submit_rating_review', 'Submit Rating / Review', 'Submeter Classificação / Revisão'),
(251, 'no_record_found', 'No Record Found', 'Nenhum Registro Encontrado'),
(252, 'payment_setting', 'Payment Setting', 'Configuração de pagamento'),
(253, 'payment_status', 'Payment Status', 'Status do pagamento'),
(254, 'update_payment_setting', 'Update Payment Setting', 'Atualizar configuração de pagamento'),
(255, 'stripe', 'Stripe', 'Stripe'),
(256, 'yes', 'Yes', 'sim'),
(257, 'no', 'No', 'Não'),
(258, 'stripe_secret_key', 'Stripe Secret Key', 'Chave Secreta Stripe'),
(259, 'stripe_publish_key', 'Stripe Publish Key', 'Stripe Publish Key'),
(260, 'payment_setting_update', 'Payment setting has been updated successfully.', 'A configuração de pagamento foi atualizada com sucesso.'),
(261, 'master', 'Master', 'mestre'),
(262, 'city', 'City', 'Cidade'),
(263, 'location', 'Location', 'Localização'),
(264, 'city_update', 'City has been updated successfully.', 'Cidade foi atualizada com sucesso.'),
(265, 'city_insert', 'City has been inserted successfully.', 'Cidade foi inserida com sucesso.'),
(266, 'city_delete', 'City has been deleted successfully.', 'Cidade foi excluída com sucesso.'),
(267, 'location_update', 'Location has been updated successfully.', 'A localização foi atualizada com sucesso.'),
(268, 'location_insert', 'Location has been inserted successfully.', 'Localização foi inserida com sucesso.'),
(269, 'location_delete', 'Location has been deleted successfully.', 'O local foi excluído com sucesso.'),
(270, 'vendor', 'Vendor', 'Fornecedor'),
(271, 'vendor_list', 'Vendor List', 'Lista de vendedores'),
(272, 'vendor_login', 'Vendor Login', 'Login do fornecedor'),
(273, 'name', 'Name', 'Nome'),
(274, 'package_name', 'Package Name', 'Nome do pacote'),
(275, 'company_name', 'Company Name', 'Nome da empresa'),
(276, 'email', 'Email', 'O email'),
(277, 'website', 'Website', 'Local na rede Internet'),
(278, 'vendor_deleted', 'Vendor has been deleted successfully.', 'O fornecedor foi excluído com sucesso.'),
(279, 'vendor_status', 'Vendor status has been changed successfully.', 'O status do fornecedor foi alterado com sucesso.'),
(280, 'vendor_Payment', 'Payment Request', 'Pedido de Pagamento'),
(281, 'event_creater', 'Event Creator', 'Criador de Eventos'),
(282, 'transfer_status', 'Transfer Status', 'Status de transferência'),
(283, 'send', 'Send', 'Enviar'),
(284, 'vendor_payment_send', 'Vendor appointment payment sent successfully.', 'Pagamento de compromisso do fornecedor enviado com sucesso.'),
(285, 'package', 'Package', 'Pacote'),
(286, 'payment_type', 'Payment Type', 'Tipo de pagamento'),
(287, 'event', 'Event', 'Evento'),
(288, 'card', 'Card', 'Cartão'),
(289, 'package_update', 'Package has been updated successfully.', 'O pacote foi atualizado com sucesso.'),
(290, 'package_insert', 'Package has been inserted successfully.', 'O pacote foi inserido com sucesso.'),
(291, 'package_delete', 'Package has been deleted successfully.', 'O pacote foi excluído com sucesso.'),
(292, 'package_list', 'Package List', 'Lista de Pacotes'),
(293, 'package_payment', 'Package Payment', 'Pagamento de Pacotes'),
(295, 'max_event', 'Max Event', 'Evento Máximo'),
(296, 'remaining_event', 'Remaining Event', 'Evento restante'),
(298, 'expired', 'Expired', 'Expirado'),
(299, 'payment_method', 'Payment Method', 'Método de pagamento'),
(301, 'cancel', 'Cancel', 'Cancelar'),
(302, 'transaction_fail', 'Your transaction is failed.Please try again.', 'Sua transação falhou. Tente novamente.'),
(303, 'transaction_success_event', 'Your transaction is success.', 'Sua transação é sucesso.'),
(304, 'invalid_card', 'Invalid card details.Please try again.', 'Detalhes do cartão inválidos.Tente novamente.'),
(306, 'select_payment', 'Select payment method first.', 'Selecione o método de pagamento primeiro.'),
(307, 'slider', 'Slider', 'Slider'),
(308, 'slider_update', 'Slider has been updated successfully.', 'Slider foi atualizado com sucesso.'),
(309, 'slider_insert', 'Slider has been inserted successfully.', 'Slider foi inserido com sucesso.'),
(310, 'slider_delete', 'Slider has been deleted successfully.', 'O controle deslizante foi excluído com sucesso.'),
(311, 'report', 'Report', 'Relatório'),
(312, 'manage_report', 'Manage Report', 'Gerenciar relatório'),
(313, 'vendor_report', 'Vendor Report', 'Relatório do fornecedor'),
(314, 'customer_report', 'Customer Report', 'Relatório do cliente'),
(315, 'select_month', 'Select Month', 'Selecione o mês'),
(316, 'select_year', 'Select Year', 'Selecione o ano'),
(317, 'January', 'January', 'janeiro'),
(318, 'february', 'February', 'fevereiro'),
(319, 'march', 'March', 'marcha'),
(320, 'april', 'April', 'abril'),
(321, 'may', 'May', 'Pode'),
(322, 'june', 'June', 'Junho'),
(323, 'july', 'July', 'Julho'),
(324, 'august', 'August', 'agosto'),
(325, 'september', 'September', 'setembro'),
(326, 'october', 'October', 'Outubro'),
(327, 'november', 'November', 'novembro'),
(328, 'december', 'December', 'dezembro'),
(329, 'monthly_new_customer', 'Monthly New Customer', 'Novo cliente mensal'),
(330, 'monthly_new_vendor', 'Monthly New Vendor', 'Fornecedor novo mensal'),
(331, 'monthly_appointment', 'Monthly Appointment', 'Nomeação mensal'),
(332, 'new_customer', 'New Customer', 'Cliente novo'),
(333, 'new_vendor', 'New Vendor', 'Novo vendedor'),
(334, 'date', 'Date', 'Encontro'),
(335, 'appointment_report', 'Appointment Report', 'Relatório de nomeação'),
(336, 'select_vendor', 'Select Vendor', 'Selecione o fornecedor'),
(337, 'month', 'Month', 'Mês'),
(338, 'invoice', 'Invoice', 'Fatura'),
(339, 'download', 'Download', 'Baixar'),
(340, 'author', 'Author', 'Autor'),
(341, 'your_rating', 'Your Rating', 'Sua avaliação'),
(342, 'rating_item', 'Rate this Item', 'Avalie este item'),
(343, 'full_name', 'Full Name', 'Nome completo'),
(344, 'member_join', 'Member Since', 'Membro desde'),
(345, 'fevicon_icon', 'Fevicon Icon', 'Ícone Favicon'),
(346, 'vendor_mail_success', 'We have sent an email with a confirmation link to your email address. Please check your email to confirm your account.', 'Enviamos um email com um link de confirmação para o seu endereço de email. Por favor, verifique seu e-mail para confirmar sua conta.'),
(348, 'event_coupon', 'Discount Coupon', 'Cupom de desconto'),
(349, 'language_setting', 'Language Setting', 'Configuração de idioma'),
(350, 'manage_language', 'Manage Language', 'Gerenciar Idioma'),
(351, 'language_translate', 'Language Translate', 'Tradutor de idioma'),
(352, 'language_add', 'Language has been added successfully.', 'Idioma foi adicionado com sucesso.'),
(353, 'language_update', 'Language has been updated successfully.', 'O idioma foi atualizado com sucesso.'),
(354, 'language_delete', 'Language has been deleted successfully.', 'O idioma foi excluído com sucesso.'),
(355, 'language_used', 'Language is already in use. You are not allowed to delete.', 'A linguagem já está em uso. Você não tem permissão para excluir.'),
(356, 'translate_word', 'Translate Word', 'Traduzir Word'),
(357, 'translated_word', 'Translated Word', 'Palavra traduzida'),
(358, 'translate', 'Translate', 'Traduzir'),
(359, 'words', 'Words', 'Palavras'),
(360, 'coupon', 'Coupon', 'Cupom'),
(361, 'code', 'Code', 'Código'),
(362, 'added_by', 'Added By', 'Adicionado por'),
(363, 'discount_type', 'Discount Type', 'Tipo de desconto'),
(364, 'discount_value', 'Discount Value', 'Valor de desconto'),
(365, 'amount', 'Amount', 'Montante'),
(366, 'percentage', 'Percentage', 'Percentagem'),
(367, 'coupon_title', 'Coupon Title', 'Título do cupom'),
(368, 'expiry_date', 'Expiry Date', 'Data de validade'),
(369, 'coupon_discount_on', 'Coupon Discount On', 'Desconto de Cupão On'),
(370, 'coupon_update', 'Coupon has been updated successfully.', 'O cupom foi atualizado com sucesso.'),
(371, 'coupon_insert', 'Coupon has been added successfully.', 'O cupom foi adicionado com sucesso.'),
(372, 'coupon_delete', 'Coupon has been deleted successfully.', 'O cupom foi excluído com sucesso.'),
(373, 'paypal_merchant_email', 'PayPal Merchant Email', 'E-mail do comerciante do PayPal'),
(374, 'paypal', 'PayPal', 'PayPal'),
(375, 'payment_by', 'Payment By', 'Pagamento por'),
(376, 'booking_note', 'Booking Note', 'Nota de reserva'),
(377, 'paypal_mode', 'PayPal Mode', 'Modo Paypal'),
(378, 'paypal_sendbox', 'PayPal Sandbox', 'Sandbox do PayPal'),
(379, 'paypal_live', 'PayPal Live', 'PayPal ao vivo'),
(381, 'seo', 'SEO', 'SEO'),
(382, 'discount', 'Discount', 'Desconto'),
(383, 'percentage', 'Percentage', 'Percentagem'),
(384, 'in', 'in', 'Dentro'),
(385, 'from_date', 'From Date', 'Da data'),
(386, 'to_date', 'To Date', 'Até a presente data'),
(387, 'discount', 'Discount', 'Desconto'),
(388, 'seo_description', 'SEO Description', 'Descrição SEO'),
(389, 'seo_keyword', 'SEO Keyword', 'SEO Keyword'),
(390, 'seo_og_image', 'SEO og Image', 'SEO e Imagem'),
(391, 'display_setting', 'Display Setting', 'Configuração de exibição'),
(392, 'Display', 'Display', 'Exibição'),
(393, 'enable', 'Enable', 'Habilitar'),
(394, 'module', 'Module', 'Módulo'),
(395, 'searching', 'Searching', 'Procurando'),
(396, 'records', 'Records', 'Registros'),
(397, 'per_page', 'Per Page', 'Por página'),
(398, 'select_language', 'Select Language', 'Selecione o idioma'),
(399, 'is_display_address', 'Do You want to show event address on map', 'Você quer mostrar o endereço do evento no mapa'),
(400, 'address', 'Address', 'Endereço'),
(401, 'invalid_coupon_code', 'Invalid coupon code.', 'Código de cupom inválido.'),
(402, 'coupon_code_expired', 'Coupon code has been expired.', 'O código do cupom expirou.'),
(403, 'coupon_code_not_associated_event', 'Given coupon code is not associated with this event.', 'Dado o código do cupom não está associado a este evento.'),
(404, 'coupon_code_apply', 'coupon code applied', 'Código de cupom aplicado'),
(405, 'google', 'Google', 'Google'),
(406, 'map', 'Map', 'Mapa'),
(407, 'key', 'Key', 'Chave'),
(408, 'header', 'Header', 'Cabeçalho'),
(409, 'color', 'Color', 'Cor'),
(410, 'code', 'Code', 'Código'),
(411, 'footer', 'Footer', 'Rodapé'),
(412, 'search', 'Search', 'Pesquisa'),
(413, 'business', 'Business', 'O negócio'),
(414, 'comission', 'Commission', 'Comissão'),
(415, 'minimum', 'Minimum', 'Mínimo'),
(416, 'vendor', 'Vendor', 'Fornecedor'),
(417, 'payout', 'Payout', 'Pagamento'),
(418, 'setting', 'Setting', 'Configuração'),
(419, 'business_setting_update', 'Business setting details updated successfully', 'Detalhes de configuração de negócios atualizados com sucesso'),
(420, 'send_mail', 'Send Mail', 'Enviar email'),
(422, 'send_event_reminder', 'Do you want to send event reminder to user?', 'Você quer enviar um lembrete de evento para o usuário?'),
(423, 'reminder_event_booking', 'Reminder For Event Booking', 'Lembrete para reserva de eventos'),
(424, 'remainder_mail_success', 'Event reminder mail send successfully', 'Mensagens de lembrete de eventos enviadas com sucesso'),
(425, 'thank_you', 'Thank You', 'Obrigado'),
(426, 'rights_reserved_message', ' All Rights Reserved.', 'Todos os direitos reservados.'),
(427, 'remainder_mail_failure', 'Event reminder mail not send successfully', 'Mensagens de lembrete de eventos não são enviadas com sucesso'),
(428, 'my_wallet_amount', 'My Wallet Amount', 'Meu valor de carteira'),
(429, 'payout_request', 'Payout Request', 'Pedido de pagamento'),
(430, 'payout_amount', 'Payout Amount', 'Montante de pagamento'),
(431, 'payout_reference', 'PayPal/Payoneer/Stripe - Email/Number', 'PayPal / Payoneer / Stripe - Email / Número'),
(432, 'chosen_payment_gateway', 'Chosen Payment Gateway', 'Gateway de Pagamento Escolhido'),
(433, 'payment_gateway', 'Payment Gateway', 'Gateway de pagamento'),
(434, 'gateway_fee_note', 'Gateway fees deducted from the total amount.<br/>Example $100.00 - 2.9% + $0.30 = $96.70', 'Taxas de gateway deduzidas do valor total. Exemplo: US $ 100,00 - 2,9% + US $ 0,30 = US $ 96,70'),
(435, 'payout_request_success', 'Your payout request has been submitted.', 'Sua solicitação de pagamento foi enviada.'),
(436, 'payout_request_error', 'Unable to create payout request.', 'Não é possível criar uma solicitação de pagamento.'),
(437, 'earnings', 'Earnings', 'Ganhos'),
(438, 'payout_notice', 'You can able to request payout once your earnings is greater or equal to ', 'Você pode solicitar o pagamento quando seus ganhos forem maiores ou iguais a'),
(439, 'payment_gateway_fee', 'Payment Gateway Fee', 'Taxa de gateway de pagamento'),
(440, 'reference_no', 'Reference No', 'Nº de referência'),
(441, 'request_date', 'Request Date', 'Data do Pedido'),
(442, 'payout_minimum_amount', 'Your payout amount must be greater or equal to', 'Seu valor de pagamento deve ser maior ou igual a'),
(443, 'payout_mail_content', 'You have new payout request from vendor.', 'Você tem uma nova solicitação de pagamento do fornecedor.'),
(444, 'vendor_name', 'Vendor Name', 'Nome do vendedor'),
(445, 'payment_gateway_fee_in_percentage', 'Payment Gateway Fee(In Percentage)', 'Taxa de gateway de pagamento (em porcentagem)'),
(446, 'updated_payment_amount', 'Updated Payment Amount', 'Montante de pagamento atualizado'),
(447, 'other_charges', 'Other Charge(In Dollar)', 'Outro encargo (em dólar)'),
(448, 'payout_process', 'Payout has been processed successfully.', 'O pagamento foi processado com sucesso.'),
(449, 'payout_success_from_admin', 'Your payout has been processed.', 'Seu pagamento foi processado.'),
(450, 'processed_date', 'Processed Date', 'Data Processada'),
(451, 'wallet_error', 'You do not have sufficient earnings to make payout request. ', 'Você não tem ganhos suficientes para fazer uma solicitação de pagamento.'),
(452, 'commission_percentage', 'percent will charged on each paid appointment as a service charge.', 'Porcentagem será cobrada em cada compromisso pago como uma taxa de serviço.'),
(453, 'appointment_payment_history', 'Appointment Payments', 'Pagamentos de nomeação'),
(454, 'vendor_amount', 'Vendor Amount', 'Valor do Fornecedor'),
(455, 'admin_amount', 'Admin Amount', 'Quantidade de administradores'),
(456, 'update_payment_status', 'Update Payment Status', 'Atualizar status do pagamento'),
(457, 'payment_received', 'Payment Received', 'Pagamento recebido'),
(458, 'status_update', 'Status has been updated successfully.', 'Status foi atualizado com sucesso.'),
(459, 'profile', 'Profile', 'Perfil'),
(460, 'mandatory_commission', 'Please select commission for admin and minimum payout for vendor', 'Comissão de Seleção Playas para Admins e Pontos Mínimos para Vandor'),
(461, 'pick_city', 'Pick a City', 'Pico da cidade'),
(462, 'finds_awesome_events', 'To find awesome event''s around you', 'Então, no campo de eventos, a rodada do evento'),
(463,'enter_your_city', 'Enter your city name', 'Digite seu nome'),
(464,'top_cities', 'Top Cities', 'Top Citi'),
(465,'search_restaurants_spa_events_city_location_vendor', 'Search restaurants, spa, events, city, location, vendor..', 'Serech Rasterts, Spa, Eventos, Cidade, Localização, Maravilha...'),
(466,'popular', 'Popular', 'Popular'),
(467,'whats_new', 'What''s New', 'o que há de novo'),
(468,'price_high_to_low', 'Price (High to Low)', 'Preço (alto a baixo)'),
(469,'price_low_to_high', 'Price (Low to High)', 'Preço (baixo para alto)'),
(470,'categories', 'Categories', 'Categorias'),
(471,'no_location_found', 'No Location Found', 'Nenhum local encontrado'),
(472,'recommanded_searches', 'Recommended Searches', 'Pesquisas Recomendadas'),
(473,'events_in', 'Events In', 'Eventos em'),
(474, 'more_info', 'More Information', 'Mais Informações'),
(475, 'go_to_profile_page', 'Go to profile page', 'Ir para a página de perfil'),
(476, 'send_message', 'Send Message', 'Enviar mensagem'),
(477, 'off', 'Off', 'fora'),
(478, 'change_location', 'Change Location', 'Mudar localização'),
(479, 'current', 'Current', 'atual'),
(480, 'load_more', 'Load More','Carregue mais');




-- --------------------------------------------------------

--
-- Table structure for table `app_location`
--

CREATE TABLE `app_location` (
  `loc_id` int(11) NOT NULL,
  `loc_city_id` int(11) NOT NULL DEFAULT '0',
  `loc_title` varchar(100) CHARACTER SET utf8 NOT NULL,
  `loc_status` enum('A','I') NOT NULL DEFAULT 'A' COMMENT 'A=active,I=inactive',
  `loc_created_by` int(11) NOT NULL DEFAULT '0',
  `loc_created_on` datetime DEFAULT NULL,
  `loc_updated_on` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `app_membership_history`
--

CREATE TABLE `app_membership_history` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL DEFAULT '0',
  `package_id` int(11) NOT NULL DEFAULT '0',
  `remaining_event` int(11) NOT NULL DEFAULT '0',
  `payment_method` varchar(100) NOT NULL,
  `payment_status` varchar(100) NOT NULL,
  `price` int(11) NOT NULL DEFAULT '0',
  `transaction_id` varchar(255) NOT NULL,
  `payment_id` varchar(255) NOT NULL,
  `customer_payment_id` varchar(255) NOT NULL,
  `failure_code` varchar(255) DEFAULT NULL,
  `failure_message` text,
  `status` enum('A','E') NOT NULL DEFAULT 'A' COMMENT 'A:Active,E:Expired',
  `created_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `app_package`
--

CREATE TABLE `app_package` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `price` varchar(100) NOT NULL,
  `max_event` varchar(100) NOT NULL,
  `status` enum('A','I') NOT NULL DEFAULT 'A' COMMENT 'A:Active ,I:Inactive',
  `created_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `app_payment_request`
--

CREATE TABLE `app_payment_request` (
  `id` int(11) NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `amount` decimal(18,2) NOT NULL,
  `updated_amount` decimal(18,2) DEFAULT NULL,
  `reference_no` varchar(255) DEFAULT NULL,
  `created_date` datetime NOT NULL,
  `processed_date` datetime DEFAULT NULL,
  `status` enum('P','H','F','S') NOT NULL COMMENT 'S=Success,P=Pending, F=Fail, H=Hold',
  `choose_payment_gateway` varchar(255) NOT NULL,
  `payment_gateway_ref` varchar(255) NOT NULL,
  `payment_gateway_fee` varchar(50) NOT NULL,
  `other_charge` decimal(18,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `app_payment_setting`
--

CREATE TABLE `app_payment_setting` (
  `id` int(11) NOT NULL,
  `stripe` enum('Y','N') NOT NULL DEFAULT 'N',
  `on_cash` enum('Y','N') NOT NULL DEFAULT 'N',
  `stripe_secret` varchar(255) DEFAULT NULL,
  `stripe_publish` varchar(255) DEFAULT NULL,
  `paypal` enum('Y','N') NOT NULL COMMENT 'Y=Yes,N=No',
  `paypal_sendbox_live` enum('S','L') NOT NULL COMMENT 'S=Sandbox,L=Live',
  `paypal_merchant_email` varchar(255) DEFAULT NULL,
  `created_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `app_rating`
--

CREATE TABLE `app_rating` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `event_id` int(11) NOT NULL DEFAULT '0',
  `rating` int(11) NOT NULL DEFAULT '0',
  `review` text NOT NULL,
  `created_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `app_site_setting`
--

CREATE TABLE `app_site_setting` (
  `id` int(11) NOT NULL,
  `company_logo` varchar(25) DEFAULT NULL,
  `banner_image` varchar(255) NOT NULL,
  `company_name` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `company_email1` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `company_email2` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `company_phone1` varchar(25) DEFAULT NULL,
  `company_phone2` varchar(25) DEFAULT NULL,
  `company_address1` text CHARACTER SET utf8,
  `company_address2` text CHARACTER SET utf8,
  `google_link` varchar(255) NOT NULL,
  `fb_link` varchar(255) DEFAULT NULL,
  `twitter_link` varchar(255) NOT NULL,
  `insta_link` varchar(255) NOT NULL,
  `linkdin_link` varchar(255) NOT NULL,
  `language` varchar(255) NOT NULL DEFAULT 'english',
  `home_page` int(11) DEFAULT '1',
  `community_banner` varchar(100) DEFAULT NULL,
  `time_zone` varchar(255) DEFAULT NULL,
  `fevicon_icon` varchar(100) DEFAULT NULL,
  `commission_percentage` int(11) NOT NULL DEFAULT '10',
  `minimum_vendor_payout` double(18,2) NOT NULL DEFAULT '50.00',
  `is_display_vendor` enum('Y','N') NOT NULL DEFAULT 'Y' COMMENT 'Y=yes,N=no',
  `is_display_category` enum('Y','N') NOT NULL DEFAULT 'Y' COMMENT 'Y=yes,N=no',
  `is_display_location` enum('Y','N') NOT NULL DEFAULT 'Y' COMMENT 'Y=yes,N=no',
  `is_display_language` enum('Y','N') NOT NULL DEFAULT 'Y' COMMENT 'Y=yes,N=no',
  `is_display_searchbar` enum('Y','N') NOT NULL DEFAULT 'Y' COMMENT 'Y=yes,N=no',
  `display_record_per_page` int(11) NOT NULL DEFAULT '12',
  `header_color_code` varchar(100) DEFAULT '#4b6499',
  `footer_color_code` varchar(100) DEFAULT '#4b6499',
  `google_map_key` varchar(100) DEFAULT NULL,
  `google_location_search_key` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `app_slider`
--

CREATE TABLE `app_slider` (
  `id` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `image` varchar(100) NOT NULL,
  `status` enum('A','I','D') NOT NULL DEFAULT 'A',
  `created_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `app_admin`
--
ALTER TABLE `app_admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `app_appointment_payment`
--
ALTER TABLE `app_appointment_payment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `app_chat`
--
ALTER TABLE `app_chat`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `app_chat_master`
--
ALTER TABLE `app_chat_master`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `app_city`
--
ALTER TABLE `app_city`
  ADD PRIMARY KEY (`city_id`);

--
-- Indexes for table `app_coupon`
--
ALTER TABLE `app_coupon`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `app_customer`
--
ALTER TABLE `app_customer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `app_email_setting`
--
ALTER TABLE `app_email_setting`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `app_event`
--
ALTER TABLE `app_event`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `app_event_book`
--
ALTER TABLE `app_event_book`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `app_event_category`
--
ALTER TABLE `app_event_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `app_language`
--
ALTER TABLE `app_language`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `app_language_data`
--
ALTER TABLE `app_language_data`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `app_location`
--
ALTER TABLE `app_location`
  ADD PRIMARY KEY (`loc_id`),
  ADD KEY `loc_city` (`loc_city_id`);

--
-- Indexes for table `app_membership_history`
--
ALTER TABLE `app_membership_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `app_package`
--
ALTER TABLE `app_package`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `app_payment_request`
--
ALTER TABLE `app_payment_request`
  ADD PRIMARY KEY (`id`),
  ADD KEY `vendor_id` (`vendor_id`);

--
-- Indexes for table `app_payment_setting`
--
ALTER TABLE `app_payment_setting`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `app_rating`
--
ALTER TABLE `app_rating`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `app_site_setting`
--
ALTER TABLE `app_site_setting`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `app_slider`
--
ALTER TABLE `app_slider`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `app_admin`
--
ALTER TABLE `app_admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `app_appointment_payment`
--
ALTER TABLE `app_appointment_payment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `app_chat`
--
ALTER TABLE `app_chat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `app_chat_master`
--
ALTER TABLE `app_chat_master`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `app_city`
--
ALTER TABLE `app_city`
  MODIFY `city_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `app_coupon`
--
ALTER TABLE `app_coupon`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `app_customer`
--
ALTER TABLE `app_customer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `app_email_setting`
--
ALTER TABLE `app_email_setting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `app_event`
--
ALTER TABLE `app_event`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `app_event_book`
--
ALTER TABLE `app_event_book`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `app_event_category`
--
ALTER TABLE `app_event_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `app_language`
--
ALTER TABLE `app_language`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `app_language_data`
--
ALTER TABLE `app_language_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=460;

--
-- AUTO_INCREMENT for table `app_location`
--
ALTER TABLE `app_location`
  MODIFY `loc_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `app_membership_history`
--
ALTER TABLE `app_membership_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `app_package`
--
ALTER TABLE `app_package`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `app_payment_request`
--
ALTER TABLE `app_payment_request`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `app_payment_setting`
--
ALTER TABLE `app_payment_setting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `app_rating`
--
ALTER TABLE `app_rating`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `app_site_setting`
--
ALTER TABLE `app_site_setting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `app_slider`
--
ALTER TABLE `app_slider`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `app_payment_request`
--
ALTER TABLE `app_payment_request`
  ADD CONSTRAINT `vendor_id` FOREIGN KEY (`vendor_id`) REFERENCES `app_admin` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

INSERT INTO `app_payment_setting` (`id`, `stripe`, `on_cash`, `stripe_secret`, `stripe_publish`, `paypal`, `paypal_sendbox_live`, `paypal_merchant_email`, `created_on`) VALUES (NULL, 'N', 'N', NULL, NULL, 'N', 'S', NULL, '2018-08-01 00:00:00');

INSERT INTO `app_admin` (`profile_image`, `first_name`, `last_name`, `email`, `password`, `phone`, `status`, `profile_status`, `type`, `company_name`, `website`, `package_id`, `profile_text`, `fb_link`, `twitter_link`, `google_link`, `default_password_changed`, `reset_password_check`, `reset_password_requested_on`, `created_on`, `updated_on`)
 VALUES ('', 'admin_first_name', 'admin_last_name', 'admin_email', 'admin_password', '', 'A', 'V', 'A', 'admin_company_name', NULL, '0', NULL, NULL, NULL, NULL, '0', '0', '0000-00-00 00:00:00', 'admin_created_at', '0000-00-00 00:00:00');

INSERT INTO `app_email_setting` (`smtp_host`, `smtp_username`, `smtp_password`, `smtp_port`, `smtp_secure`, `email_from_name`)
 VALUES ('email_smtp_host', 'email_smtp_username', 'email_smtp_password', 'email_smtp_port', 'email_smtp_secure', 'email_smtp_username');
 
 INSERT INTO `app_site_setting` (`company_logo`, `banner_image`, `company_name`, `company_email1`, `company_email2`, `company_phone1`, `company_phone2`, `company_address1`, `company_address2`, `google_link`, `fb_link`, `twitter_link`, `insta_link`, `linkdin_link`)
 VALUES ('site_setting_company_logo', '', 'site_setting_company_name', 'site_setting_company_email', NULL, NULL, NULL, NULL, NULL, '', NULL, '', '', '');